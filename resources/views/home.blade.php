<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Outfit Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-stone-50 text-gray-800">

<header class="sticky top-0 z-50 backdrop-blur bg-white/90 border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold tracking-tight">Color Outfit Recommendation</h1>
            <p class="text-xs text-gray-500">Project Data Sains</p>
        </div>

        <nav class="hidden md:flex items-center gap-8 text-sm text-gray-600">
            <a href="#home" class="hover:text-black transition">Home</a>
            <a href="#about" class="hover:text-black transition">About</a>
            <a href="#team" class="hover:text-black transition">Team</a>
        </nav>

        <a href="{{ route('upload') }}"
           class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-black transition">
            Upload Gambar
        </a>
    </div>
</header>

<section id="home" class="py-20 md:py-28">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-stone-200 text-stone-700 mb-5">
            Tugas Kelompok Data Sains
        </span>

        <h2 class="text-4xl md:text-5xl font-semibold leading-tight tracking-tight mb-6">
            Analisis warna outfit dari gambar dengan tampilan yang sederhana dan rapi
        </h2>

        <p class="text-gray-600 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            Aplikasi ini membantu pengguna melihat warna dominan dari outfit yang diupload,
            kemudian menampilkan palette warna serta rekomendasi kombinasi yang sesuai.
        </p>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('upload') }}"
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-black transition">
                Mulai Analisis
            </a>

            <a href="#about"
               class="px-6 py-3 rounded-xl border border-stone-300 text-gray-700 hover:bg-white transition">
                Pelajari Lebih Lanjut
            </a>
        </div>

        <div class="mt-14 border-t border-stone-200 w-32 mx-auto"></div>
    </div>
</section>

<section id="about" class="py-20 bg-white border-y border-stone-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-3xl">
            <h3 class="text-3xl font-semibold tracking-tight mb-6">About</h3>
            <p class="text-gray-600 leading-relaxed mb-4">
                Sistem ini memakai crop area yang dipilih pengguna agar analisis lebih fokus pada outfit, lalu gambar hasil crop dikirim ke model untuk mengekstrak palette dominan dan membuat rekomendasi kombinasi secara dinamis.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Implementasi backend menggunakan Laravel dan pemanggilan OpenAI API melalui Responses API.
            </p>
        </div>
    </div>
</section>

<section id="team" class="py-20 bg-white border-t border-stone-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-12 text-center">
            <h3 class="text-3xl font-semibold tracking-tight mb-3">Team Members</h3>
            <p class="text-gray-600">Anggota kelompok pengembang aplikasi</p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <div class="bg-stone-50 border border-stone-200 rounded-2xl p-5 text-center">
                <img src="{{ asset('images/team/anggota1.jpg') }}" alt="Foto anggota 1" class="w-20 h-20 mx-auto rounded-full object-cover border border-stone-300 mb-4">
                <p class="text-sm font-semibold">NIM 1</p>
                <p class="text-sm text-gray-600 mt-1">Nama 1</p>
            </div>
            <div class="bg-stone-50 border border-stone-200 rounded-2xl p-5 text-center">
                <img src="{{ asset('images/team/anggota2.jpg') }}" alt="Foto anggota 2" class="w-20 h-20 mx-auto rounded-full object-cover border border-stone-300 mb-4">
                <p class="text-sm font-semibold">NIM 2</p>
                <p class="text-sm text-gray-600 mt-1">Nama 2</p>
            </div>
            <div class="bg-stone-50 border border-stone-200 rounded-2xl p-5 text-center">
                <img src="{{ asset('images/team/anggota3.jpg') }}" alt="Foto anggota 3" class="w-20 h-20 mx-auto rounded-full object-cover border border-stone-300 mb-4">
                <p class="text-sm font-semibold">NIM 3</p>
                <p class="text-sm text-gray-600 mt-1">Nama 3</p>
            </div>
            <div class="bg-stone-50 border border-stone-200 rounded-2xl p-5 text-center">
                <img src="{{ asset('images/team/anggota4.jpg') }}" alt="Foto anggota 4" class="w-20 h-20 mx-auto rounded-full object-cover border border-stone-300 mb-4">
                <p class="text-sm font-semibold">NIM 4</p>
                <p class="text-sm text-gray-600 mt-1">Nama 4</p>
            </div>
            <div class="bg-stone-50 border border-stone-200 rounded-2xl p-5 text-center">
                <img src="{{ asset('images/team/anggota5.jpg') }}" alt="Foto anggota 5" class="w-20 h-20 mx-auto rounded-full object-cover border border-stone-300 mb-4">
                <p class="text-sm font-semibold">NIM 5</p>
                <p class="text-sm text-gray-600 mt-1">Nama 5</p>
            </div>
        </div>
    </div>
</section>

<footer class="py-8 bg-stone-900 text-stone-300">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-sm">© 2026 Color Outfit Recommendation</p>
        <div class="flex gap-6 text-sm">
            <a href="#home" class="hover:text-white transition">Home</a>
            <a href="#about" class="hover:text-white transition">About</a>
            <a href="#team" class="hover:text-white transition">Team</a>
        </div>
    </div>
</footer>

</body>
</html>