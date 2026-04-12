<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutfitController;
use Illuminate\Support\Facades\Http;

Route::get('/test-gemini', function () {
    $response = Http::withHeaders([
        'x-goog-api-key' => env('GEMINI_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post(
        'https://generativelanguage.googleapis.com/v1beta/models/' . env('GEMINI_MODEL', 'gemini-2.5-flash') . ':generateContent',
        [
            'contents' => [
                [
                    'parts' => [
                        ['text' => 'Balas hanya dengan kata: OK']
                    ]
                ]
            ]
        ]
    );

    return [
        'status' => $response->status(),
        'body' => $response->json(),
    ];
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/upload', [OutfitController::class, 'index'])->name('upload');
Route::post('/upload', [OutfitController::class, 'store'])->name('upload.store');