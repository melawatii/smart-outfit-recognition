<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis Outfit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-stone-50 min-h-screen text-gray-800">

<header class="border-b border-stone-200 bg-white/90 backdrop-blur">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold">Hasil Analisis Outfit</h1>
            <p class="text-xs text-gray-500">Palette warna dan rekomendasi berbasis AI</p>
        </div>

        <a href="{{ route('upload') }}" class="text-sm text-gray-600 hover:text-black transition">
            ← Upload Lagi
        </a>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-10">
    <div class="grid lg:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Gambar Asli</h2>
                <img
                    src="{{ asset('storage/' . $imagePath) }}"
                    alt="Uploaded Outfit"
                    class="w-full rounded-2xl border border-stone-200"
                >
            </div>

            @if (!empty($cropPreview))
                <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold mb-4">Area Crop yang Dianalisis</h2>
                    <img
                        src="{{ asset('storage/' . $cropPreview) }}"
                        alt="Cropped Outfit"
                        class="w-full rounded-2xl border border-stone-200"
                    >
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Top 5 Palette Warna</h2>

                <div class="space-y-4">
                    @foreach ($palette as $index => $color)
                        <div class="flex items-center gap-4 p-3 bg-stone-50 rounded-2xl border border-stone-200">
                            <div
                                class="w-16 h-16 rounded-xl border border-stone-300"
                                style="background-color: {{ $color['hex'] }};"
                            ></div>

                            <div class="text-sm text-gray-700">
                                <p class="font-semibold">Warna {{ $index + 1 }} - {{ $color['label'] }}</p>
                                <p>HEX: {{ $color['hex'] }}</p>
                                <p>Dominasi: {{ $color['percentage'] }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Top 3 Warna Utama</h2>

                <div class="grid grid-cols-3 gap-4">
                    @foreach ($topColors as $color)
                        <div class="bg-stone-50 rounded-2xl border border-stone-200 p-4 text-center">
                            <div
                                class="w-full h-16 rounded-xl border border-stone-300 mb-3"
                                style="background-color: {{ $color['hex'] }};"
                            ></div>
                            <p class="text-xs font-medium">{{ $color['hex'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $color['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Rekomendasi Kombinasi</h2>

                <div class="space-y-3 text-sm text-gray-700">
                    <p><span class="font-medium">Warna utama:</span> {{ $recommendation['main'] ?? '-' }}</p>
                    <p><span class="font-medium">Warna pendamping:</span> {{ $recommendation['secondary'] ?? '-' }}</p>
                    <p><span class="font-medium">Warna aksen:</span> {{ $recommendation['accent'] ?? '-' }}</p>
                    <p><span class="font-medium">Saran bawahan:</span> {{ $recommendation['bottom'] ?? '-' }}</p>
                    <p><span class="font-medium">Saran sepatu:</span> {{ $recommendation['shoes'] ?? '-' }}</p>
                    <p><span class="font-medium">Saran aksesoris:</span> {{ $recommendation['accessory'] ?? '-' }}</p>
                </div>

                <div class="mt-5 p-4 bg-stone-50 rounded-2xl border border-stone-200">
                    <p class="text-sm text-gray-600">
                        {{ $recommendation['description'] ?? '-' }}
                    </p>
                </div>

                @if (!empty($summary))
                    <div class="mt-4 p-4 bg-stone-50 rounded-2xl border border-stone-200">
                        <p class="text-sm text-gray-700">
                            <span class="font-medium">Ringkasan:</span> {{ $summary }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

</body>
</html>