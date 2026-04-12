<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OutfitController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_width' => 'nullable|numeric',
            'crop_height' => 'nullable|numeric',
            'display_width' => 'nullable|numeric',
            'display_height' => 'nullable|numeric',
        ]);

        $path = $request->file('image')->store('outfits', 'public');
        $fullPath = storage_path('app/public/' . $path);

        $crop = [
            'x' => (float) $request->input('crop_x', 0),
            'y' => (float) $request->input('crop_y', 0),
            'width' => (float) $request->input('crop_width', 0),
            'height' => (float) $request->input('crop_height', 0),
            'display_width' => (float) $request->input('display_width', 0),
            'display_height' => (float) $request->input('display_height', 0),
        ];

        $cropped = $this->createCroppedImageData($fullPath, $crop);

        try {
            $analysis = $this->analyzeWithGemini(
                $cropped['base64'],
                $cropped['mime_type']
            );

            return view('result', [
                'imagePath' => $path,
                'palette' => $analysis['palette'] ?? [],
                'topColors' => array_slice($analysis['palette'] ?? [], 0, 3),
                'recommendation' => $analysis['recommendation'] ?? [],
                'summary' => $analysis['summary'] ?? null,
                'cropPreview' => $cropped['relative_path'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Gemini analysis failed', [
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withErrors([
                    'image' => 'Analisis Gemini gagal. Cek API key, kuota, koneksi internet, atau format respons.'
                ])
                ->withInput();
        }
    }

    private function analyzeWithGemini(string $base64Image, string $mimeType): array
    {
        $apiKey = env('GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-2.5-flash');

        if (! $apiKey) {
            throw new \RuntimeException('GEMINI_API_KEY belum diatur di file .env');
        }

        $prompt = <<<PROMPT
Analisis outfit pada gambar dan balas hanya dalam JSON valid.

Keluarkan format:
{
  "palette": [
    { "hex": "#AABBCC", "percentage": 27.5, "label": "Soft Blue" }
  ],
  "recommendation": {
    "main": "#AABBCC",
    "secondary": "#DDEEFF",
    "accent": "#112233",
    "bottom": "text",
    "shoes": "text",
    "accessory": "text",
    "description": "text"
  },
  "summary": "text"
}

Aturan:
- Fokus pada pakaian di gambar.
- Identifikasi 5 warna dominan.
- Persentase 0-100.
- Label warna harus dinamis sesuai gambar.
- Rekomendasi kombinasi harus dinamis, bukan template.
- Jangan tambahkan markdown atau penjelasan di luar JSON.
PROMPT;

        $response = Http::withHeaders([
    'x-goog-api-key' => $apiKey,
    'Content-Type' => 'application/json',
])->timeout(90)->post(
    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
    [
        'contents' => [
            [
                'parts' => [
                    [
                        'inline_data' => [
                            'mime_type' => $mimeType,
                            'data' => $base64Image,
                        ],
                    ],
                    [
                        'text' => $prompt,
                    ],
                ],
            ],
        ],
        'generationConfig' => [
            'temperature' => 0.1,
            'maxOutputTokens' => 2200,
            'responseMimeType' => 'application/json',
            'thinkingConfig' => [
                'thinkingBudget' => 0,
            ],
        ],
    ]
);

        // dd($response->json());

        if ($response->failed()) {
            throw new \RuntimeException('Gemini request gagal: ' . $response->body());
        }

        $json = $response->json();
        $text = $this->extractGeminiText($json);

        if (! $text) {
            throw new \RuntimeException('Tidak menemukan output teks dari Gemini.');
        }

        $decoded = $this->decodeJsonSafely($text);

        if (! is_array($decoded)) {
            throw new \RuntimeException('Output Gemini bukan JSON valid.');
        }

        return $this->normalizeAnalysis($decoded);
    }

    private function extractGeminiText(array $response): ?string
    {
        $candidates = $response['candidates'] ?? [];

        foreach ($candidates as $candidate) {
            $parts = data_get($candidate, 'content.parts', []);

            foreach ($parts as $part) {
                if (! empty($part['text'])) {
                    return trim($part['text']);
                }
            }
        }

        return null;
    }

    private function decodeJsonSafely(string $text): ?array
    {
        $decoded = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        if (preg_match('/\{.*\}/s', $text, $matches)) {
            $decoded = json_decode($matches[0], true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return null;
    }

    private function normalizeAnalysis(array $data): array
    {
        $palette = collect($data['palette'] ?? [])
            ->filter(fn ($item) => is_array($item) && ! empty($item['hex']))
            ->map(function ($item) {
                $hex = strtoupper(trim((string) ($item['hex'] ?? '')));
                $percentage = (float) ($item['percentage'] ?? 0);
                $label = trim((string) ($item['label'] ?? 'Color'));

                return [
                    'hex' => $this->normalizeHex($hex),
                    'percentage' => round($percentage, 2),
                    'label' => $label !== '' ? $label : 'Color',
                ];
            })
            ->sortByDesc('percentage')
            ->values()
            ->all();

        $recommendation = $data['recommendation'] ?? [];

        return [
            'palette' => $palette,
            'recommendation' => [
                'main' => $this->normalizeNullableHex($recommendation['main'] ?? null),
                'secondary' => $this->normalizeNullableHex($recommendation['secondary'] ?? null),
                'accent' => $this->normalizeNullableHex($recommendation['accent'] ?? null),
                'bottom' => (string) ($recommendation['bottom'] ?? '-'),
                'shoes' => (string) ($recommendation['shoes'] ?? '-'),
                'accessory' => (string) ($recommendation['accessory'] ?? '-'),
                'description' => (string) ($recommendation['description'] ?? '-'),
            ],
            'summary' => (string) ($data['summary'] ?? ''),
        ];
    }

    private function normalizeHex(string $hex): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (! preg_match('/^[0-9A-Fa-f]{6}$/', $hex)) {
            return '#000000';
        }

        return '#' . strtoupper($hex);
    }

    private function normalizeNullableHex(?string $hex): ?string
    {
        if (! $hex) {
            return null;
        }

        return $this->normalizeHex($hex);
    }

    private function createCroppedImageData(string $imagePath, array $crop): array
    {
        $imageInfo = \getimagesize($imagePath);

        if (! $imageInfo) {
            throw new \RuntimeException('Gagal membaca file gambar.');
        }

        $mime = $imageInfo['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $sourceImage = \imagecreatefromjpeg($imagePath);
                $outputMime = 'image/png';
                break;
            case 'image/png':
                $sourceImage = \imagecreatefrompng($imagePath);
                $outputMime = 'image/png';
                break;
            default:
                throw new \RuntimeException('Format gambar tidak didukung.');
        }

        if (! $sourceImage) {
            throw new \RuntimeException('Gagal memproses gambar.');
        }

        $originalWidth = \imagesx($sourceImage);
        $originalHeight = \imagesy($sourceImage);

        [$srcX, $srcY, $srcWidth, $srcHeight] = $this->resolveCropArea(
            $originalWidth,
            $originalHeight,
            $crop
        );

        $croppedImage = \imagecreatetruecolor($srcWidth, $srcHeight);

        \imagecopy(
            $croppedImage,
            $sourceImage,
            0,
            0,
            $srcX,
            $srcY,
            $srcWidth,
            $srcHeight
        );

        $relativeDir = 'cropped';
        $absoluteDir = storage_path('app/public/' . $relativeDir);

        if (! is_dir($absoluteDir)) {
            mkdir($absoluteDir, 0755, true);
        }

        $filename = 'crop_' . uniqid() . '.png';
        $absolutePath = $absoluteDir . '/' . $filename;
        $relativePath = $relativeDir . '/' . $filename;

        \imagepng($croppedImage, $absolutePath);

        ob_start();
        \imagepng($croppedImage);
        $binary = ob_get_clean();

        \imagedestroy($sourceImage);
        \imagedestroy($croppedImage);

        if ($binary === false) {
            throw new \RuntimeException('Gagal membuat data gambar crop.');
        }

        return [
            'base64' => base64_encode($binary),
            'mime_type' => $outputMime,
            'relative_path' => $relativePath,
        ];
    }

    private function resolveCropArea(int $originalWidth, int $originalHeight, array $crop): array
    {
        $displayWidth = (float) ($crop['display_width'] ?? 0);
        $displayHeight = (float) ($crop['display_height'] ?? 0);
        $cropX = (float) ($crop['x'] ?? 0);
        $cropY = (float) ($crop['y'] ?? 0);
        $cropWidth = (float) ($crop['width'] ?? 0);
        $cropHeight = (float) ($crop['height'] ?? 0);

        if (
            $displayWidth <= 0 || $displayHeight <= 0 ||
            $cropWidth <= 0 || $cropHeight <= 0
        ) {
            $fallbackWidth = (int) round($originalWidth * 0.55);
            $fallbackHeight = (int) round($originalHeight * 0.7);
            $fallbackX = (int) round(($originalWidth - $fallbackWidth) / 2);
            $fallbackY = (int) round(($originalHeight - $fallbackHeight) / 2);

            return [$fallbackX, $fallbackY, $fallbackWidth, $fallbackHeight];
        }

        $scaleX = $originalWidth / $displayWidth;
        $scaleY = $originalHeight / $displayHeight;

        $srcX = max(0, (int) round($cropX * $scaleX));
        $srcY = max(0, (int) round($cropY * $scaleY));
        $srcWidth = max(1, (int) round($cropWidth * $scaleX));
        $srcHeight = max(1, (int) round($cropHeight * $scaleY));

        if ($srcX + $srcWidth > $originalWidth) {
            $srcWidth = $originalWidth - $srcX;
        }

        if ($srcY + $srcHeight > $originalHeight) {
            $srcHeight = $originalHeight - $srcY;
        }

        return [$srcX, $srcY, $srcWidth, $srcHeight];
    }
}