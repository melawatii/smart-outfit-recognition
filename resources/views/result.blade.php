<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitScan - Smart Outfit Recognition</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Crimson+Text:wght@400;600;700&family=EB+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

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

        body {
            background-color: #EFF3FB;
        }

        body::before {
            content: '';
            position: fixed;
            bottom: 0;
            left: 0;
            width: 420px;
            height: 220px;
            background: linear-gradient(135deg, #C7D9F5 0%, #B8CCF0 100%);
            border-radius: 0 80px 0 0;
            opacity: 0.5;
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: 0;
            right: 0;
            width: 260px;
            height: 160px;
            background: linear-gradient(135deg, #D4E4FA 0%, #C2D6F5 100%);
            border-radius: 80px 0 0 0;
            opacity: 0.45;
            pointer-events: none;
            z-index: 0;
        }

        .site-header {
            background-color: #ffffff;
            border-bottom: 1px solid #E2EAF6;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .back-link {
            color: #3B6DB4;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #2d5a9e;
        }

        .panel-card {
            background: #ffffff;
            border: 1px solid #E2EAF6;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(59, 100, 180, 0.06);
        }

        .card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-icon-bubble {
            width: 44px;
            height: 44px;
            background: #EBF2FF;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-icon-bubble svg {
            color: #3B6DB4;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1A2F5A;
            font-family: "Inter", sans-serif;
        }

        .theme-divider {
            height: 3px;
            width: 50px;
            border-radius: 9999px;
            background: linear-gradient(to right, #3B6DB4, #73A5CA);
            margin-top: 8px;
        }

        .image-frame {
            border: 1px solid #E2EAF6;
            border-radius: 16px;
            overflow: hidden;
            background: #F7FAFF;
        }

        .outfit-chip {
            background: #F7FAFF;
            border: 1px solid #E2EAF6;
            border-radius: 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .outfit-icon-bubble {
            width: 42px;
            height: 42px;
            background: #EBF2FF;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .outfit-icon-bubble svg {
            color: #3B6DB4;
        }

        .outfit-chip-name {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #1A2F5A;
        }

        .outfit-chip-sub {
            font-size: 0.8125rem;
            color: #6B7DA8;
            margin-top: 2px;
        }

        .pct-badge {
            margin-left: auto;
            background: #EBF2FF;
            color: #3B6DB4;
            font-size: 0.875rem;
            font-weight: 700;
            border-radius: 9999px;
            padding: 4px 14px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .summary-box {
            background: #F7FAFF;
            border: 1px solid #E2EAF6;
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .summary-box-icon {
            color: #3B6DB4;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .summary-box-text {
            font-size: 0.875rem;
            color: #4A6A9B;
            line-height: 1.6;
        }
    </style>
</head>

<body class="min-h-screen text-gray-800 font-body">

    <!--begin::Header-->
    <header class="site-header">
        <!--begin::Container-->
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <!--begin::Brand-->
            <div>
                <!--begin::Brand Title-->
                <h1 class="text-lg font-title tracking-wide">
                    <!--begin::Brand Primary-->
                    <span style="color:#3B6DB4;">FitScan</span>
                    <!--end::Brand Primary-->
                    <!--begin::Brand Secondary-->
                    <span style="color:#E87F24;">AI</span>
                    <!--end::Brand Secondary-->
                </h1>
                <!--end::Brand Title-->
            </div>
            <!--end::Brand-->
            <!--begin::Back Link-->
            <a href="{{ route('upload') }}" class="back-link font-elegant">
                <!--begin::Back Link Icon-->
                <span>←</span>
                <!--end::Back Link Icon-->
                <!--begin::Back Link Text-->
                <span>Unggah Lagi</span>
                <!--end::Back Link Text-->
            </a>
            <!--end::Back Link-->
        </div>
        <!--end::Container-->
    </header>
    <!--end::Header-->

    <!--begin::Main-->
    <main class="max-w-6xl mx-auto px-6 py-10" style="position:relative; z-index:1;">
        <!--begin::Grid-->
        <div class="grid lg:grid-cols-2 gap-8">
            <!--begin::Left Column-->
            <div class="space-y-6">

                <!--begin::Original Image Card-->
                <div class="panel-card p-6">
                    <!--begin::Card Header-->
                    <div class="card-header">
                        <!--begin::Title Group-->
                        <div>
                            <!--begin::Title-->
                            <h2 class="section-title">Gambar Asli</h2>
                            <!--end::Title-->
                            <!--begin::Divider-->
                            <div class="theme-divider"></div>
                            <!--end::Divider-->
                        </div>
                        <!--end::Title Group-->
                        <!--begin::Icon Bubble-->
                        <div class="section-icon-bubble">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <!--end::Icon Bubble-->
                    </div>
                    <!--end::Card Header-->
                    <!--begin::Image Wrapper-->
                    <div class="image-frame">
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Uploaded Outfit" class="w-full">
                    </div>
                    <!--end::Image Wrapper-->
                </div>
                <!--end::Original Image Card-->

                @if (!empty($cropPreview))
                    <!--begin::Crop Image Card-->
                    <div class="panel-card p-6">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <!--begin::Title Group-->
                            <div>
                                <!--begin::Title-->
                                <h2 class="section-title">Area Crop yang Dianalisis</h2>
                                <!--end::Title-->
                                <!--begin::Divider-->
                                <div class="theme-divider"></div>
                                <!--end::Divider-->
                            </div>
                            <!--end::Title Group-->
                            <!--begin::Icon Bubble-->
                            <div class="section-icon-bubble">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M8 3H5a2 2 0 00-2 2v3M16 3h3a2 2 0 012 2v3M8 21H5a2 2 0 01-2-2v-3M16 21h3a2 2 0 002-2v-3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <!--end::Icon Bubble-->
                        </div>
                        <!--end::Card Header-->
                        <!--begin::Image Wrapper-->
                        <div class="image-frame">
                            <img src="http://127.0.0.1:9000/{{ $cropPreview }}" alt="Cropped Outfit" class="w-full">
                        </div>
                        <!--end::Image Wrapper-->
                    </div>
                    <!--end::Crop Image Card-->
                @endif

            </div>
            <!--end::Left Column-->

            <!--begin::Right Column-->
            <div class="space-y-6">

                <!--begin::Outfit Result Card-->
                <div class="panel-card p-6">
                    <!--begin::Card Header-->
                    <div class="card-header">
                        <!--begin::Title Group-->
                        <div>
                            <!--begin::Title-->
                            <h2 class="section-title">Hasil Identifikasi Outfit</h2>
                            <!--end::Title-->
                            <!--begin::Divider-->
                            <div class="theme-divider"></div>
                            <!--end::Divider-->
                        </div>
                        <!--end::Title Group-->
                        <!--begin::Icon Bubble-->
                        <div class="section-icon-bubble">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H5v10a1 1 0 001 1h12a1 1 0 001-1V10h1.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <!--end::Icon Bubble-->
                    </div>
                    <!--end::Card Header-->
                    <!--begin::Outfit List-->
                    <div class="space-y-3">
                        @foreach ($outfits as $index => $item)
                            <!--begin::Outfit Item-->
                            <div class="outfit-chip">
                                <!--begin::Outfit Icon-->
                                <div class="outfit-icon-bubble">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H5v10a1 1 0 001 1h12a1 1 0 001-1V10h1.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <!--end::Outfit Icon-->
                                <!--begin::Outfit Info-->
                                <div>
                                    <!--begin::Outfit Name-->
                                    <p class="outfit-chip-name">
                                        {{ ucfirst($item['type']) }}
                                    </p>
                                    <!--end::Outfit Name-->
                                    <!--begin::Outfit Sub-->
                                    <p class="outfit-chip-sub">{{ $item['category'] ?? 'Casual / Formal Wear' }}</p>
                                    <!--end::Outfit Sub-->
                                </div>
                                <!--end::Outfit Info-->
                                <!--begin::Percentage Badge-->
                                <span class="pct-badge">{{ $item['percentage'] }}%</span>
                                <!--end::Percentage Badge-->
                            </div>
                            <!--end::Outfit Item-->
                        @endforeach
                    </div>
                    <!--end::Outfit List-->
                </div>
                <!--end::Outfit Result Card-->

                @if (!empty($recommendation))

                <!--begin::Recommendation Card-->
                <div class="panel-card p-6">

                    <!--begin::Card Header-->
                    <div class="card-header">

                        <div>
                            <h2 class="section-title">
                                Rekomendasi Outfit
                            </h2>

                            <div class="theme-divider"></div>
                        </div>

                        <div class="section-icon-bubble">
                            <svg width="20"
                                height="20"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </div>

                    </div>
                    <!--end::Card Header-->

                    <div class="space-y-4">

                        <div class="outfit-chip">
                            <div>
                                <p class="outfit-chip-name">
                                    Style
                                </p>

                                <p class="outfit-chip-sub">
                                    {{ ucfirst($recommendation['style'] ?? '-') }}
                                </p>
                            </div>
                        </div>

                        <div class="summary-box">
                            <p class="summary-box-text">
                                {{ $recommendation['description'] ?? '-' }}
                            </p>
                        </div>

                        <div class="outfit-chip">
                            <div>
                                <p class="outfit-chip-name">
                                    Cocok Untuk
                                </p>

                                <p class="outfit-chip-sub">
                                    {{ $recommendation['occasion'] ?? '-' }}
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
                <!--end::Recommendation Card-->

                @endif

            </div>
            <!--end::Right Column-->
        </div>
        <!--end::Grid-->
    </main>
    <!--end::Main-->

</body>
</html>
