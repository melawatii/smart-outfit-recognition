<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OutfitController extends Controller
{
    /**
     * Display the outfit upload form.
     *
     * @return void
     */
    public function index()
    {
        return view('upload');
    }

    /**
     * Handle the outfit image upload and analysis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_width' => 'nullable|numeric',
            'crop_height' => 'nullable|numeric',
            'display_width' => 'nullable|numeric',
            'display_height' => 'nullable|numeric',
        ]);

        // Store the uploaded image
        $path = $request->file('image')->store('outfits', 'public');
        $fullPath = storage_path('app/public/' . $path);

        // Prepare crop data
        $crop = [
            'x' => (float) $request->input('crop_x', 0),
            'y' => (float) $request->input('crop_y', 0),
            'width' => (float) $request->input('crop_width', 0),
            'height' => (float) $request->input('crop_height', 0),
            'display_width' => (float) $request->input('display_width', 0),
            'display_height' => (float) $request->input('display_height', 0),
        ];

        // Create cropped image data for Gemini analysis
        $cropped = $this->createCroppedImageData($fullPath, $crop);

        // Analyze with Gemini and handle response
        try {
            // Log the size of the cropped image data
            $analysis = $this->analyzeWithGemini($cropped['base64'], $cropped['mime_type']);

            session()->regenerate();

            // Log the analysis result for debugging
            return view('result', [
                'imagePath' => $path,
                'outfits' => $analysis['outfits'] ?? [],
                'summary' => $analysis['summary'] ?? null,
                'recommendation' => $analysis['recommendation'] ?? [],
                'cropPreview' => $cropped['relative_path'],
            ]);
        } catch (\Throwable $e) {
            // Log the error for debugging
            Log::error('Gemini analysis failed', ['message' => $e->getMessage()]);
            return back()->withErrors(['image' => 'Analisis Gemini gagal. Cek API key, kuota, koneksi internet, atau format respons.'])->withInput();
        }
    }

    /**
     * Analyze the outfit image using Gemini API.
     *
     * @param  string  $base64Image
     * @param  string  $mimeType
     * @return array
     */
    private function analyzeWithGemini(string $base64Image, string $mimeType): array
    {
        // Load API key and model from environment variables
        $apiKey = env('GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-2.5-flash');

        // Validate API key presence
        if (!$apiKey) {
            throw new \RuntimeException('GEMINI_API_KEY belum diatur di file .env');
        }

        // Construct the prompt for Gemini
        $prompt = <<<PROMPT
                    Gambar ini adalah hasil crop yang hanya berisi area outfit.
                    Analisis hanya pakaian yang terlihat pada gambar ini dan abaikan bagian di luar crop.

                    Balas hanya dalam JSON valid.

                    Keluarkan format:
                    {
                        "outfits": [
                            { "type": "Jaket", "category": "outerwear", "percentage": 55 },
                            { "type": "Kaos", "category": "top", "percentage": 25 },
                            { "type": "Celana Jeans", "category": "bottom", "percentage": 15 },
                            { "type": "Sepatu", "category": "footwear", "percentage": 5 }
                        ],
                        "summary": "text",
                        "recommendation": {
                            "style": "Casual Modern",
                            "description": "Outfit cocok digunakan untuk aktivitas santai dan hangout.",
                            "match_colors": ["Putih", "Navy", "Beige"],
                            "occasion": "Daily Casual",
                            "fashion_tips": "Gunakan outfit dengan warna netral agar terlihat lebih clean dan modern.",
                            "pairing_items": [
                                "Sneakers putih",
                                "Celana chino beige",
                                "Jam tangan silver",
                                "Totebag canvas"
                            ]
                        }
                    }

                    Aturan:
                    - Analisis hanya outfit yang terlihat pada gambar crop ini
                    - Jangan mengasumsikan pakaian di luar gambar
                    - Identifikasi semua jenis outfit yang terlihat
                    - Setiap jenis outfit memiliki nilai 0-100
                    - Total seluruh nilai harus 100
                    - Berdasarkan dominasi visual pada gambar
                    - Berikan rekomendasi style fashion sesuai outfit
                    - Berikan warna yang cocok dipadukan
                    - Gunakan bahasa Indonesia
                    - Jangan tambahkan markdown atau teks di luar JSON
                    - Berikan rekomendasi item fashion yang cocok dipadukan dengan outfit
                    - pairing_items berisi item fashion tambahan yang cocok digunakan
                    - fashion_tips berisi tips styling singkat
                    - Rekomendasi harus realistis dan sesuai outfit pada gambar
                    - Hindari rekomendasi berlebihan atau tidak relevan
                    PROMPT;

        // Send request to Gemini API
        $response = Http::retry(3, 2000)
                    ->withHeaders([
                        'x-goog-api-key' => $apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->timeout(90)->post(
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

        // Handle response and extract text
        if ($response->failed()) {
            throw new \RuntimeException('Gemini request gagal: ' . $response->body());
        }

        // Log the raw response for debugging
        $json = $response->json();

        if (
            empty($json['candidates']) ||
            !isset($json['candidates'][0]['content'])
        ) {
            throw new \RuntimeException('Response Gemini kosong atau invalid.');
        }

        $text = $this->extractGeminiText($json);

        // Log the extracted text for debugging
        if (!$text) {
            throw new \RuntimeException('Tidak menemukan output teks dari Gemini.');
        }

        // Attempt to decode JSON from the extracted text
        $decoded = $this->decodeJsonSafely($text);

        // Log the decoded JSON for debugging
        if (!is_array($decoded)) {
            throw new \RuntimeException('Output Gemini bukan JSON valid.');
        }

        return $this->normalizeAnalysis($decoded);
    }

    /**
     * Extract the text content from Gemini response.
     *
     * @param  array  $response
     * @return string|null
     */
    private function extractGeminiText(array $response): ?string
    {
        // Log the structure of the response for debugging
        $candidates = $response['candidates'] ?? [];

        // Gemini will return the generated content in the 'parts' array of the first candidate
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

    /**
     * Attempt to decode JSON from text, with fallback for extraneous content.
     *
     * @param  string  $text
     * @return array|null
     */
    private function decodeJsonSafely(string $text): ?array
    {
        // First attempt to decode the entire text
        $decoded = json_decode($text, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // If that fails, try to extract JSON substring using regex
        if (preg_match('/\{.*\}/s', $text, $matches)) {
            $decoded = json_decode($matches[0], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return null;
    }

    /**
     * Normalize the analysis data to ensure consistent structure and formatting.
     *
     * @param  array  $data
     * @return array
     */
    private function normalizeAnalysis(array $data): array
    {
        $outfits = collect($data['outfits'] ?? [])
                    ->filter(fn ($item) => is_array($item) && !empty($item['type']))
                    ->map(function ($item) {
                        return [
                            'type' => trim((string) ($item['type'] ?? 'Unknown')),
                            'category' => trim((string) ($item['category'] ?? '')),
                            'percentage' => round((float) ($item['percentage'] ?? 0), 2),
                        ];
                    })
                    ->sortByDesc('percentage')
                    ->values()
                    ->all();

        return [
            'outfits' => $outfits,
            'summary' => (string) ($data['summary'] ?? ''),
            'recommendation' => $data['recommendation'] ?? [],
        ];
    }

    /**
     * Normalize a hex color code to ensure it's in the format #RRGGBB.
     *
     * @param  string  $hex
     * @return string
     */
    private function normalizeHex(string $hex): string
    {
        // Remove any leading '#' and convert to uppercase
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        // Validate that it's a valid 6-character hex code
        if (! preg_match('/^[0-9A-Fa-f]{6}$/', $hex)) {
            return '#000000';
        }

        return '#' . strtoupper($hex);
    }

    /**
     * Normalize a nullable hex color code, returning null if input is empty or invalid.
     *
     * @param  string|null  $hex
     * @return string|null
     */
    private function normalizeNullableHex(?string $hex): ?string
    {
        if (! $hex) {
            return null;
        }

        return $this->normalizeHex($hex);
    }

    /**
     * Create cropped image data from the original image and crop parameters.
     *
     * @param  string  $imagePath
     * @param  array  $crop
     * @return array
     */
    private function createCroppedImageData(string $imagePath, array $crop): array
    {
        // Get image info and create source image resource
        $imageInfo = \getimagesize($imagePath);
        if (!$imageInfo) {
            throw new \RuntimeException('Gagal membaca file gambar.');
        }

        // Log the image info for debugging
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

        // Log the source image creation for debugging
        if (!$sourceImage) {
            throw new \RuntimeException('Gagal memproses gambar.');
        }

        // Get original dimensions and calculate crop area
        $originalWidth = \imagesx($sourceImage);
        $originalHeight = \imagesy($sourceImage);
        [$srcX, $srcY, $srcWidth, $srcHeight] = $this->resolveCropArea($originalWidth, $originalHeight, $crop);

        // Log the resolved crop area for debugging
        $croppedImage = \imagecreatetruecolor($srcWidth, $srcHeight);

        // Preserve transparency for PNG
        \imagecopy($croppedImage, $sourceImage, 0, 0, $srcX, $srcY, $srcWidth, $srcHeight);

        // Save the cropped image to a temporary location
        $relativeDir = 'cropped';
        $absoluteDir = storage_path('app/public/' . $relativeDir);

        // Ensure the directory exists
        if (!is_dir($absoluteDir)) {
            mkdir($absoluteDir, 0755, true);
        }

        // Generate a unique filename for the cropped image
        $filename = 'crop_' . uniqid() . '.png';
        $absolutePath = $absoluteDir . '/' . $filename;
        $relativePath = $relativeDir . '/' . $filename;

        // Save the cropped image as PNG
        \imagepng($croppedImage, $absolutePath);

        // Capture the binary data of the cropped image for Gemini analysis
        ob_start();
        \imagepng($croppedImage);
        $binary = ob_get_clean();

        // Clean up image resources
        \imagedestroy($sourceImage);
        \imagedestroy($croppedImage);

        // Log the size of the cropped image data for debugging
        if ($binary === false) {
            throw new \RuntimeException('Gagal membuat data gambar crop.');
        }

        // Return the base64-encoded cropped image data along with MIME type and relative path
        return [
            'base64' => base64_encode($binary),
            'mime_type' => $outputMime,
            'relative_path' => $relativePath,
        ];
    }

    /**
     * Resolve the crop area based on original dimensions and crop parameters, with fallback.
     *
     * @param  int  $originalWidth
     * @param  int  $originalHeight
     * @param  array  $crop
     * @return array
     */
    private function resolveCropArea(int $originalWidth, int $originalHeight, array $crop): array
    {
        // Log the crop parameters for debugging
        $displayWidth = (float) ($crop['display_width'] ?? 0);
        $displayHeight = (float) ($crop['display_height'] ?? 0);
        $cropX = (float) ($crop['x'] ?? 0);
        $cropY = (float) ($crop['y'] ?? 0);
        $cropWidth = (float) ($crop['width'] ?? 0);
        $cropHeight = (float) ($crop['height'] ?? 0);

        // If any of the crop parameters are invalid, use a centered crop area as fallback
        if ($displayWidth <= 0 || $displayHeight <= 0 || $cropWidth <= 0 || $cropHeight <= 0) {
            $fallbackWidth = (int) round($originalWidth * 0.55);
            $fallbackHeight = (int) round($originalHeight * 0.7);
            $fallbackX = (int) round(($originalWidth - $fallbackWidth) / 2);
            $fallbackY = (int) round(($originalHeight - $fallbackHeight) / 2);

            return [$fallbackX, $fallbackY, $fallbackWidth, $fallbackHeight];
        }

        // Calculate the scaling factors to convert display crop coordinates to original image coordinates
        $scaleX = $originalWidth / $displayWidth;
        $scaleY = $originalHeight / $displayHeight;

        // Calculate the source crop area in original image coordinates
        $srcX = max(0, (int) round($cropX * $scaleX));
        $srcY = max(0, (int) round($cropY * $scaleY));
        $srcWidth = max(1, (int) round($cropWidth * $scaleX));
        $srcHeight = max(1, (int) round($cropHeight * $scaleY));

        // Ensure the crop area does not exceed the original image boundaries
        if ($srcX + $srcWidth > $originalWidth) {
            $srcWidth = $originalWidth - $srcX;
        }

        // Ensure the crop area does not exceed the original image boundaries
        if ($srcY + $srcHeight > $originalHeight) {
            $srcHeight = $originalHeight - $srcY;
        }

        return [$srcX, $srcY, $srcWidth, $srcHeight];
    }
}
