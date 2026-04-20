<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Outfit Recommendation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Crimson+Text:wght@400;600;700&family=EB+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <style>
        html {
            scroll-behavior: smooth;
        }
        
        .font-title {
            font-family: "Bungee", sans-serif;
        }

        .font-body {
            font-family: "Inter", sans-serif;
        }

        .font-accent {
            font-family: "Crimson Text", serif;
        }

        .font-elegant {
            font-family: "EB Garamond", serif;
        }

        .nav-link {
            position: relative;
            color: #4b4b4b;
            text-decoration: none;
            transition: all 0.3s ease;
            padding-bottom: 4px;
        }

        .nav-link:hover {
            color: #E87F24;
        }

        .nav-link.active {
            color: #E87F24;
        }

        .nav-link.active::after, .nav-link:hover::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 100%;
            height: 2px;
            background-color: #FFC81E;
            border-radius: 999px;
        }

        .team-card {
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(255,200,30,0.45);
            border-radius: 22px;
            padding: 24px 18px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            backdrop-filter: blur(6px);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 14px 30px rgba(232,127,36,0.18);
            border-color: #73A5CA;
        }

        .team-photo-wrap {
            width: 120px;
            height: 120px;
            margin: 0 auto 16px;
            padding: 4px;
            border-radius: 999px;
            background: linear-gradient(135deg, #E87F24, #FFC81E, #73A5CA);
        }

        .team-img {
            width: 100%;
            height: 100%;
            border-radius: 999px;
            object-fit: cover;
            display: block;
            background: #fff;
        }

        .team-nim {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .team-name {
            font-size: 0.95rem;
            color: #4b5563;
        }
    </style>
</head>

<body class="bg-stone-50 text-gray-800">
    <!--begin::Header-->
    <header class="sticky top-0 z-50 backdrop-blur bg-[#FEFDDF]/90 border-b border-[#FFC81E]/40">
        <!--begin::Header Container-->
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!--begin::Header Left-->
            <div>
                <!--begin::Header Title-->
                <h1 class="text-xl font-title tracking-wide">
                    <!--begin::Title Primary-->
                    <span class="text-[#73A5CA]">Color</span>
                    <!--end::Title Primary-->
                    <!--begin::Title Secondary-->
                    <span class="text-[#E87F24]">Outfit</span>
                    <!--end::Title Secondary-->
                </h1>
                <!--end::Header Title-->
            </div>
            <!--end::Header Left-->
            <!--begin::Header Menu-->
            <nav class="hidden md:flex items-center gap-10 text-sm font-elegant text-gray-800">
                <!--begin::Menu Item-->
                <a href="#home" class="nav-link">HOME</a>
                <!--end::Menu Item-->
                <!--begin::Menu Item-->
                <a href="#about" class="nav-link">ABOUT</a>
                <!--end::Menu Item-->
                <!--begin::Menu Item-->
                <a href="#team" class="nav-link">TEAM</a>
                <!--end::Menu Item-->
            </nav>
            <!--end::Header Menu-->
            <!--begin::Header Action-->
            <a href="{{ route('upload') }}" class="inline-flex items-center px-5 py-2 rounded-xl bg-[#E87F24] text-white text-sm font-medium shadow-sm hover:bg-[#FFC81E] hover:text-gray-900 transition">
                Upload Gambar
            </a>
            <!--end::Header Action-->
        </div>
        <!--end::Header Container-->
    </header>
    <!--end::Header-->

    <!--begin::Hero Section-->
    <section id="home" class="relative py-20 md:py-28 text-white overflow-hidden">
        <!--begin::Background-->
        <div class="absolute inset-0">
            <!--begin::Background Image-->
            <img src="{{ asset('assets/images/background.jpg') }}" class="w-full h-full object-cover" alt="Background Outfit">
            <!--end::Background Image-->
            <!--begin::Overlay Dark-->
            <div class="absolute inset-0 bg-black/60"></div>
            <!--end::Overlay Dark-->
        </div>
        <!--end::Background-->
        <!--begin::Content-->
        <div class="relative max-w-4xl mx-auto px-6 text-center">
            <!--begin::Hero Title-->
            <h2 class="text-3xl md:text-4xl leading-tight tracking-tight mb-6 font-title">
                <span class="text-[#FFC81E]">Analisis warna</span><br>
                <span class="text-[#E87F24]">outfit dari gambar</span><br>
                <span class="text-white">dengan tampilan yang sederhana dan rapi</span>
            </h2>
            <!--end::Hero Title-->
            <!--begin::Hero Description-->
            <p class="text-gray-200 text-lg leading-relaxed mb-10 max-w-xl mx-auto">
                Aplikasi ini membantu pengguna melihat warna dominan dari outfit yang diupload, kemudian menampilkan palette warna serta rekomendasi kombinasi yang sesuai.
            </p>
            <!--end::Hero Description-->
            <!--begin::Hero Actions-->
            <div class="flex flex-wrap justify-center gap-4">
                <!--begin::Primary Button-->
                <a href="{{ route('upload') }}" class="px-6 py-3 rounded-xl text-white font-medium transition" style="background-color:#E87F24;" onmouseover="this.style.backgroundColor='#FFC81E'; this.style.color='#1f2937';" onmouseout="this.style.backgroundColor='#E87F24'; this.style.color='white';">     
                    Mulai Analisis
                </a>
                <!--end::Primary Button-->
                <!--begin::Secondary Button-->
                <a href="#about" class="px-6 py-3 rounded-xl border font-medium transition" style="border-color:#FFC81E; color:#FFC81E;" onmouseover="this.style.backgroundColor='#FFC81E'; this.style.color='#1f2937';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#FFC81E';">
                    Pelajari Lebih Lanjut
                </a>
                <!--end::Secondary Button-->
            </div>
            <!--end::Hero Actions-->
        </div>
        <!--end::Content-->
    </section>
    <!--end::Hero Section-->

    <!--begin::About Section-->
    <section id="about" class="relative py-20 border-y overflow-hidden" style="background-color:#FEFDDF; border-color:#FFC81E;">
        <!--begin::Background Decoration-->
        <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full blur-3xl opacity-20" style="background:#FFC81E;"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full blur-3xl opacity-20" style="background:#73A5CA;"></div>
        <!--end::Background Decoration-->
        <!--begin::Container-->
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <!--begin::Content Wrapper-->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!--begin::About Text-->
                <div>
                    <!--begin::Section Title-->
                    <h3 class="text-3xl md:text-4xl mb-6 font-title relative inline-block" style="color:#E87F24;">
                        About
                        <!--begin::Title Underline-->
                        <span class="block h-[4px] w-20 mt-2 rounded-full" style="background:linear-gradient(to right,#E87F24,#FFC81E,#73A5CA);"></span>
                        <!--end::Title Underline-->
                    </h3>
                    <!--end::Section Title-->
                    <!--begin::Section Description-->
                    <p class="leading-relaxed mb-4 text-lg" style="color:#374151;">
                        Website ini dirancang untuk membantu pengguna menganalisis warna outfit dari gambar yang diunggah. Pengguna dapat memilih area tertentu pada gambar agar proses analisis lebih fokus pada bagian pakaian yang ingin diperiksa.
                    </p>
                    <p class="leading-relaxed mb-4 text-lg" style="color:#374151;">
                        Setelah gambar diproses, sistem akan mengekstrak warna dominan dari outfit, lalu menampilkan palette warna utama beserta rekomendasi kombinasi warna yang serasi. Dengan begitu, pengguna bisa lebih mudah memahami kecocokan warna outfit secara visual.
                    </p>
                    <p class="leading-relaxed text-lg" style="color:#374151;">
                        Website ini dibangun menggunakan Laravel sebagai backend dan memanfaatkan GeminiAI API untuk membantu proses analisis serta menghasilkan rekomendasi warna yang lebih dinamis dan relevan.
                    </p>
                    <!--end::Section Description-->
                </div>
                <!--end::About Text-->
                <!--begin::About Image-->
                <div class="flex justify-center relative">
                    <!--begin::Image Glow-->
                    <div class="absolute w-72 h-72 rounded-full blur-2xl opacity-30" style="background:linear-gradient(#E87F24,#FFC81E,#73A5CA);"></div>
                    <!--end::Image Glow-->
                    <!--begin::Image Card-->
                    <div class="relative rounded-3xl p-6 shadow-xl transition hover:scale-105" style="background-color:white; border:1px solid #FFC81E;">
                        <img src="{{ asset('assets/images/about-undraw.png') }}" alt="Ilustrasi analisis outfit" class="w-full max-w-md mx-auto">
                    </div>
                    <!--end::Image Card-->
                </div>
                <!--end::About Image-->
            </div>
            <!--end::Content Wrapper-->
        </div>
        <!--end::Container-->
    </section>
    <!--end::About Section-->

    <!--begin::Team Section-->
    <section id="team" class="py-24 relative overflow-hidden" style="background-color:#FEFDDF;">
        <!--begin::Background Decoration-->
        <div class="absolute -top-10 -left-10 w-40 h-40 rounded-full opacity-20" style="background-color:#FFC81E;"></div>
        <div class="absolute bottom-0 right-0 w-56 h-56 rounded-full opacity-10" style="background-color:#73A5CA;"></div>
        <!--end::Background Decoration-->
        <!--begin::Container-->
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <!--begin::Section Header-->
            <div class="mb-14 text-center">
                <!--begin::Section Title-->
                <h3 class="text-3xl md:text-4xl font-title mb-3" style="color:#E87F24;">
                    TEAM MEMBERS
                </h3>
                <!--end::Section Title-->
                <!--begin::Section Subtitle-->
                <p class="text-gray-700 font-elegant text-lg">
                    Anggota kelompok pengembang aplikasi
                </p>
                <!--end::Section Subtitle-->
                <!--begin::Section Divider-->
                <div class="mt-4 flex justify-center">
                    <div class="w-28 h-1 rounded-full"
                        style="background:linear-gradient(to right,#E87F24,#FFC81E,#73A5CA);">
                    </div>
                </div>
                <!--end::Section Divider-->
            </div>
            <!--end::Section Header-->
            <!--begin::Team Grid-->
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!--begin::Team Member-->
                <div class="team-card">
                    <div class="team-photo-wrap">
                        <img src="{{ asset('assets/images/profile-1.jpeg') }}" class="team-img">
                    </div>
                    <p class="team-nim">15240566</p>
                    <p class="team-name">Fitria Rahmadani</p>
                </div>
                <!--end::Team Member-->
                <!--begin::Team Member-->
                <div class="team-card">
                    <div class="team-photo-wrap">
                        <img src="{{ asset('assets/images/profile-2.jpeg') }}" class="team-img">
                    </div>
                    <p class="team-nim">15240053</p>
                    <p class="team-name">Ryan Raphael Setiawan</p>
                </div>
                <!--end::Team Member-->
                <!--begin::Team Member-->
                <div class="team-card">
                    <div class="team-photo-wrap">
                        <img src="{{ asset('assets/images/profile-3.jpeg') }}" class="team-img">
                    </div>
                    <p class="team-nim">15240086</p>
                    <p class="team-name">Melawati</p>
                </div>
                <!--end::Team Member-->
                <!--begin::Team Member-->
                <div class="team-card">
                    <div class="team-photo-wrap">
                        <img src="{{ asset('assets/images/profile-4.webp') }}" class="team-img">
                    </div>
                    <p class="team-nim">15240681</p>
                    <p class="team-name">Muhammad Rivan Aldiansyah</p>
                </div>
                <!--end::Team Member-->
                <!--begin::Team Member-->
                <div class="team-card">
                    <div class="team-photo-wrap">
                        <img src="{{ asset('assets/images/profile-5.png') }}" class="team-img">
                    </div>
                    <p class="team-nim">15240148</p>
                    <p class="team-name">Wafiq Nur Aliyah</p>
                </div>
                <!--end::Team Member-->
            </div>
            <!--end::Team Grid-->
        </div>
        <!--end::Container-->
    </section>
    <!--end::Team Section-->

    <!--begin::Footer-->
    <footer class="py-8 text-white font-body" style="background-color:#73A5CA;">
        <!--begin::Container-->
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <!--begin::Copyright-->
            <p class="text-sm opacity-90">
                © 2026 
                AI <span class="font-title text-[#FFC81E]">Color Outfit</span> Recommendation
            </p>
            <!--end::Copyright-->
            <!--begin::Footer Navigation-->
            <div class="flex gap-6 text-sm font-elegant tracking-wide">
                <!--begin::Nav Item-->
                <a href="#home" class="hover:text-[#FFC81E] transition">HOME</a>
                <!--end::Nav Item-->
                <!--begin::Nav Item-->
                <a href="#about" class="hover:text-[#FFC81E] transition">ABOUT</a>
                <!--end::Nav Item-->
                <!--begin::Nav Item-->
                <a href="#team" class="hover:text-[#FFC81E] transition">TEAM</a>
                <!--end::Nav Item-->
            </div>
            <!--end::Footer Navigation-->
        </div>
        <!--end::Container-->
    </footer>
    <!--end::Footer-->
    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>