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
        $request->validate([
            'image' => 'required|image|max:10240',
            'original_image' => 'required|image|max:10240',
        ]);

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
                            ->timeout(30)
                            ->post($pythonApi, [
                                [
                                    'name' => 'file',
                                    'contents' => $croppedBinary,
                                    'filename' => 'cropped.webp'
                                ]
                            ]);

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
            return back()->withErrors([
                'image' => $e->getMessage()
            ]);
        }
    }
}
