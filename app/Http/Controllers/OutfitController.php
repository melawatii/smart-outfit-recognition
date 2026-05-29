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
        // Validate uploaded image
        $request->validate(
            [
                'image'                     => 'required|image|mimes:jpg,jpeg,png,webp,heic,heif|max:10240', // 10MB
                'original_image'            => 'required|image|mimes:jpg,jpeg,png,webp,heic,heif|max:10240', // 10MB
            ],
            [
                'image.required'            => 'Please select an image first.',
                'image.image'               => 'The uploaded file must be an image.',
                'image.mimes'               => 'Only JPG, JPEG, PNG, HEIC, HEIF and WEBP formats are supported.',
                'image.max'                 => 'Image size must not exceed 10 MB.',
                'original_image.required'   => 'Original image is required.',
                'original_image.image'      => 'The uploaded file must be an image.',
                'original_image.mimes'      => 'Only JPG, JPEG, PNG, HEIC, HEIF and WEBP formats are supported.',
                'original_image.max'        => 'Image size must not exceed 10 MB.',
            ]
        );

        try {
            // Store image temporarily

            // Local
            // $path = $request->file('original_image')->store(
            //                     'uploads',
            //                     'public'
            //                 );
            // $fullPath = storage_path('app/public/' . $path);

            // Deployed
            $image = $request->file('original_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
            $image->move($destinationPath, $imageName);
            $path = 'uploads/' . $imageName;

            $croppedImage = $request->cropped_image;
            $croppedImage =
                str_replace(
                    'data:image/webp;base64,',
                    '',
                    $croppedImage
                );

            $croppedImage =
                str_replace(
                    ' ',
                    '+',
                    $croppedImage
                );

            $croppedBinary = base64_decode($croppedImage);

            // Send image to Python API
            // $pythonApi = 'http://127.0.0.1:9000/predict'; // Local API
            $pythonApi = 'https://melawatii-outfit-ai-chip.hf.space/predict'; // Deployed API

            $response = Http::asMultipart()
                            ->timeout(60)
                            ->post($pythonApi, [
                                [
                                    'name' => 'file',
                                    'contents' => $croppedBinary,
                                    'filename' => 'cropped.webp'
                                ]
                            ]);

                            if ($response->failed()) {
                                $message = 'Failed to connect to AI server. Please try again later.';

                                if ($response->status() === 413) {
                                    $message = 'Image size is too large.';
                                }

                                if ($response->status() === 415) {
                                    $message = 'Unsupported image format.';
                                }

                                return back()->withErrors([
                                    'image' => $message
                                ]);
                            }


            // Handle API failure
            if ($response->failed()) {
                return back()->withErrors([
                    'image' => 'Python AI API tidak dapat dihubungi.'
                ]);
            }
            $result = $response->json();

            // Handle invalid outfit image
            if (!$result['success']) {
                return back()->withErrors([
                    'image' => $result['message']
                ])->withInput();
            }
            $data = $result['data'];

            $summary = $data['summary'] ?? null;

            if (is_array($summary)) {
                $summary = implode(', ', $summary);
            }

            return view('result', [
                'imagePath' => $path,
                'outfits' => $data['outfits'] ?? [],
                'summary' => $summary,
                'recommendation' => $data['recommendation'] ?? [],
                'cropPreview' => $data['crop_preview'] ?? null,
            ]);

        } catch (\Throwable $e) {
            Log::error('Outfit Prediction Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $message = 'An unexpected error occurred. Please try again.';

            if (str_contains($e->getMessage(), 'timed out')) {
                $message = 'AI server response timeout. Please try again.';
            }

            if (str_contains($e->getMessage(), 'cURL error')) {
                $message = 'Failed to connect to AI server.';
            }

            return back()->withErrors([
                'image' => $message
            ]);

        }
    }
}
