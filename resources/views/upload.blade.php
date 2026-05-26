<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitScan - Smart Outfit Recognition</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .panel-card {
            background: #ffffff;
            border: 1px solid #E2EAF6;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(59, 100, 180, 0.06);
        }
        .section-icon-bubble {
            width: 52px;
            height: 52px;
            background: #EBF2FF;
            border-radius: 14px;
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

        .section-desc {
            font-size: 0.8125rem;
            color: #6B7DA8;
            line-height: 1.6;
        }
        .theme-divider {
            height: 3px;
            width: 60px;
            border-radius: 9999px;
            background: linear-gradient(to right, #3B6DB4, #73A5CA);
            margin-top: 10px;
        }
        .step-badge {
            width: 26px;
            height: 26px;
            background: #3B6DB4;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #ffffff;
            flex-shrink: 0;
        }

        .step-label {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #1A2F5A;
        }
        .step-block {
            background: #F7FAFF;
            border: 1px solid #DDEAF8;
            border-radius: 14px;
            padding: 16px;
        }
        .source-btn-main {
            width: 100%;
            background: #3B6DB4;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .source-btn-main:hover {
            background: #2d5a9e;
        }
        .source-btn-sub-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }
        #subBtnRow.hidden {
            display: none !important;
        }

        .source-btn-secondary {
            background: #ffffff;
            color: #374151;
            border: 1px solid #DDEAF8;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.8125rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: border-color 0.2s, background 0.2s;
        }

        .source-btn-secondary:hover {
            border-color: #3B6DB4;
            background: #F0F6FF;
            color: #3B6DB4;
        }

        .source-btn-secondary.active {
            background: #E8F0FB;
            border-color: #3B6DB4;
            color: #3B6DB4;
        }
        .file-input-styled {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid #DDEAF8;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.8125rem;
            color: #374151;
        }

        .file-input-styled input[type="file"] {
            flex: 1;
            font-size: 0.8125rem;
            color: #374151;
            background: transparent;
            border: none;
            outline: none;
        }
        .tip-box {
            background: #F0F6FF;
            border: 1px solid #BBCFEC;
            border-radius: 12px;
            padding: 12px 14px;
        }

        .tip-box-title {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #1A2F5A;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .tip-box-text {
            font-size: 0.8125rem;
            color: #4A6A9B;
            line-height: 1.5;
        }
        .bullet-list {
            list-style: disc;
            padding-left: 18px;
            font-size: 0.8125rem;
            color: #4A6A9B;
            line-height: 1.7;
        }
        .camera-btn-primary {
            flex: 1;
            background: #3B6DB4;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .camera-btn-primary:hover {
            background: #2d5a9e;
        }

        .camera-btn-outline {
            flex: 1;
            background: #ffffff;
            color: #3B6DB4;
            border: 1px solid #BBCFEC;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: border-color 0.2s, background 0.2s;
        }

        .camera-btn-outline:hover {
            border-color: #3B6DB4;
            background: #F0F6FF;
        }

        .camera-btn-outline:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }
        .crop-box {
            position: absolute;
            border: 2px solid #3B6DB4;
            background: rgba(59, 109, 180, 0.1);
            cursor: move;
            box-shadow: 0 0 0 9999px rgba(15, 30, 70, 0.3);
            border-radius: 10px;
        }

        .crop-handle {
            position: absolute;
            width: 14px;
            height: 14px;
            right: -7px;
            bottom: -7px;
            background: #3B6DB4;
            border: 2px solid #ffffff;
            border-radius: 9999px;
            cursor: nwse-resize;
        }
        .submit-btn {
            width: 100%;
            background: #3B6DB4;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s;
        }

        .submit-btn:hover {
            background: #2d5a9e;
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 9999px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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
        .empty-state-box {
            border: 2px dashed #A8C4E8;
            border-radius: 16px;
            background: #F7FAFF;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        #emptyState.hidden {
            display: none !important;
        }

        .empty-state-icon {
            color: #B8CCE8;
        }

        .empty-state-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1A2F5A;
        }

        .empty-state-desc {
            font-size: 0.8125rem;
            color: #6B7DA8;
            text-align: center;
            max-width: 280px;
        }
        #previewWrapper {
            border: 1px solid #DDEAF8;
            border-radius: 16px;
            overflow: hidden;
            background: #F7FAFF;
        }
        .info-box {
            background: #F7FAFF;
            border: 1px solid #DDEAF8;
            border-radius: 12px;
            padding: 14px;
        }

        .info-box-title {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #1A2F5A;
            margin-bottom: 4px;
        }

        .info-box-text {
            font-size: 0.8125rem;
            color: #6B7DA8;
        }

        .status-chip {
            display: inline-block;
            margin-top: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 9999px;
        }

        .status-chip-ready {
            background: #D4EDDA;
            color: #1A5E35;
        }

        .status-chip-pending {
            background: #E8F0FB;
            color: #3B6DB4;
        }
        .loading-hint {
            background: #F0F6FF;
            border: 1px solid #BBCFEC;
            border-radius: 12px;
            padding: 14px;
            margin-top: 12px;
        }
        .camera-preview-box {
            background: #F7FAFF;
            border: 1px solid #DDEAF8;
            border-radius: 12px;
            padding: 12px;
            overflow: hidden;
        }

        .camera-placeholder-box {
            height: 200px;
            border: 2px dashed #A8C4E8;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: #ffffff;
        }
        #cameraPlaceholder.hidden {
            display: none !important;
        }
        .error-alert {
            background: #FFF1F2;
            border: 1px solid #FDA4AF;
            border-radius: 12px;
            color: #BE123C;
            padding: 14px;
            font-size: 0.8125rem;
            margin-bottom: 16px;
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
            <a href="{{ route('home') }}" class="back-link font-elegant">
                <!--begin::Back Link Icon-->
                <span>←</span>
                <!--end::Back Link Icon-->
                <!--begin::Back Link Text-->
                <span>Kembali ke Beranda</span>
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
        <div class="grid lg:grid-cols-3 gap-8">
            <!--begin::Left Panel-->
            <div class="lg:col-span-1">
                <!--begin::Left Card-->
                <div class="panel-card p-6">
                    <!--begin::Section Header-->
                    <div class="flex items-start gap-4 mb-6">
                        <!--begin::Icon Bubble-->
                        <div class="section-icon-bubble">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 16v-4M12 8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 16.5A9 9 0 0112 3v0" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 3.5A9 9 0 0121 12" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <!--end::Icon Bubble-->
                        <!--begin::Title Group-->
                        <div>
                            <!--begin::Title-->
                            <h2 class="section-title">Unggah Gambar</h2>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <p class="section-desc mt-1">
                                Pilih sumber gambar terlebih dahulu, lalu siapkan foto outfit agar sistem dapat mengidentifikasi jenis pakaian yang dikenakan dengan lebih akurat.
                            </p>
                            <!--end::Description-->
                            <!--begin::Divider-->
                            <div class="theme-divider"></div>
                            <!--end::Divider-->
                        </div>
                        <!--end::Title Group-->
                    </div>
                    <!--end::Section Header-->

                    @if ($errors->any())
                        <!--begin::Error Alert-->
                        <div class="error-alert">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!--end::Error Alert-->
                    @endif

                    <!--begin::Form-->
                    <form id="uploadForm" action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!--begin::Step 1 - Source Picker-->
                        <div class="step-block">
                            <!--begin::Step Header-->
                            <div class="flex items-center gap-2 mb-3">
                                <div class="step-badge">1</div>
                                <span class="step-label">Pilih sumber gambar</span>
                            </div>
                            <!--end::Step Header-->

                            <!--begin::Main Upload Button-->
                            <button type="button" id="tabUpload" class="source-btn-main">
                                <!--begin::Upload Icon-->
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="17 8 12 3 7 8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="12" y1="3" x2="12" y2="15" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <!--end::Upload Icon-->
                                Unggah
                            </button>
                            <!--end::Main Upload Button-->

                            <!--begin::Sub Buttons Row-->
                            <div id="subBtnRow" class="source-btn-sub-row">
                                <!--begin::Camera Button-->
                                <button type="button" id="tabCamera" class="source-btn-secondary">
                                    <!--begin::Camera Icon-->
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="13" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <!--end::Camera Icon-->
                                    Gunakan Kamera
                                </button>
                                <!--end::Camera Button-->
                                <!--begin::Device Button-->
                                <button type="button" id="tabDevice" class="source-btn-secondary">
                                    <!--begin::Device Icon-->
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <!--end::Device Icon-->
                                    Pilih dari Perangkat
                                </button>
                                <!--end::Device Button-->
                            </div>
                            <!--end::Sub Buttons Row-->
                        </div>
                        <!--end::Step 1-->

                        <!--begin::Upload Mode-->
                        <div id="uploadMode" class="hidden step-block space-y-3">
                            <!--begin::Step Header-->
                            <div class="flex items-center gap-2 mb-1">
                                <div class="step-badge">2</div>
                                <span class="step-label">Pilih file gambar</span>
                            </div>
                            <!--end::Step Header-->
                            <!--begin::File Input-->
                            <div class="file-input-styled">
                                <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png">
                            </div>
                            <!--end::File Input-->
                            <!--begin::Tips-->
                            <div class="tip-box">
                                <!--begin::Tips Title-->
                                <p class="tip-box-title">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#3B6DB4;">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 8v4M12 16h.01" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Saran
                                </p>
                                <!--end::Tips Title-->
                                <!--begin::Tips Text-->
                                <p class="tip-box-text">
                                    Gunakan foto yang fokus ke outfit agar sistem dapat mengidentifikasi jenis pakaian dengan lebih akurat.
                                </p>
                                <!--end::Tips Text-->
                            </div>
                            <!--end::Tips-->
                        </div>
                        <!--end::Upload Mode-->

                        <!--begin::Camera Mode-->
                        <div id="cameraMode" class="hidden step-block space-y-3">
                            <!--begin::Step Header-->
                            <div class="flex items-center gap-2 mb-1">
                                <div class="step-badge">2</div>
                                <span class="step-label">Kontrol kamera</span>
                            </div>
                            <!--end::Step Header-->
                            <!--begin::Camera Preview-->
                            <div class="camera-preview-box">
                                <!--begin::Video-->
                                <video id="cameraVideo" autoplay playsinline class="w-full rounded-xl bg-black hidden"></video>
                                <!--end::Video-->
                                <!--begin::Canvas-->
                                <canvas id="cameraCanvas" class="hidden"></canvas>
                                <!--end::Canvas-->
                                <!--begin::Placeholder-->
                                <div id="cameraPlaceholder" class="camera-placeholder-box">
                                    <div>
                                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#A8C4E8; margin:0 auto 8px;">
                                            <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                            <circle cx="12" cy="13" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700">Kamera belum aktif</p>
                                        <p class="text-xs text-gray-500 mt-1">Klik tombol mulai kamera untuk menampilkan preview kamera.</p>
                                    </div>
                                </div>
                                <!--end::Placeholder-->
                            </div>
                            <!--end::Camera Preview-->
                            <!--begin::Camera Buttons-->
                            <div class="flex gap-3">
                                <!--begin::Start Camera Button-->
                                <button type="button" id="startCameraBtn" class="camera-btn-primary">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polygon points="5 3 19 12 5 21 5 3" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Mulai Kamera
                                </button>
                                <!--end::Start Camera Button-->
                                <!--begin::Capture Button-->
                                <button type="button" id="capturePhotoBtn" class="camera-btn-outline" disabled>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Ambil Foto
                                </button>
                                <!--end::Capture Button-->
                            </div>
                            <!--end::Camera Buttons-->
                            <!--begin::Switch & Retake-->
                            <div class="flex gap-3">
                                <!--begin::Switch Camera Button-->
                                <button type="button" id="switchCameraBtn" class="camera-btn-outline" style="flex:1;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="1 4 1 10 7 10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3.51 15a9 9 0 102.13-9.36L1 10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Ganti Kamera
                                </button>
                                <!--end::Switch Camera Button-->
                                <!--begin::Retake Button-->
                                <button type="button" id="retakePhotoBtn" class="camera-btn-outline hidden" style="flex:1;">
                                    Ambil Ulang
                                </button>
                                <!--end::Retake Button-->
                            </div>
                            <!--end::Switch & Retake-->
                            <!--begin::Camera Guide-->
                            <div class="tip-box">
                                <!--begin::Guide Title-->
                                <p class="tip-box-title">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#3B6DB4;">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 8v4M12 16h.01" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Alur penggunaan kamera
                                </p>
                                <!--end::Guide Title-->
                                <!--begin::Guide List-->
                                <ol class="tip-box-text list-decimal list-inside space-y-1">
                                    <li>Klik <strong>Mulai Kamera</strong></li>
                                    <li>Arahkan kamera ke outfit</li>
                                    <li>Klik <strong>Ambil Foto</strong></li>
                                    <li>Atur area crop pada preview</li>
                                </ol>
                                <!--end::Guide List-->
                            </div>
                            <!--end::Camera Guide-->
                        </div>
                        <!--end::Camera Mode-->

                        <!--begin::Step 3 - Crop Instruction-->
                        <div class="step-block">
                            <!--begin::Step Header-->
                            <div class="flex items-center gap-2 mb-2">
                                <div class="step-badge">3</div>
                                <span class="step-label">Atur area crop</span>
                            </div>
                            <!--end::Step Header-->
                            <!--begin::Instruction List-->
                            <ul class="bullet-list">
                                <li>Geser kotak crop ke area pakaian.</li>
                                <li>Tarik titik kanan bawah untuk memperbesar atau memperkecil area.</li>
                                <li>Area di luar kotak crop tidak akan dianalisis.</li>
                            </ul>
                            <!--end::Instruction List-->
                        </div>
                        <!--end::Step 3-->

                        <input
                            type="hidden"
                            name="cropped_image"
                            id="cropped_image"
                        >

                        <!--begin::Submit Section-->
                        <div>
                            <!--begin::Submit Button-->
                            <button type="submit" id="submitButton" class="submit-btn">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span id="submitText">Analisis Gambar</span>
                                <span id="submitSpinner" class="spinner hidden"></span>
                            </button>
                            <!--end::Submit Button-->
                            <!--begin::Loading Hint-->
                            <div id="loadingHint" class="loading-hint hidden">
                                <p class="tip-box-title">AI sedang menganalisis gambar</p>
                                <p class="tip-box-text">
                                    Mohon tunggu beberapa saat. Sistem sedang memproses gambar dan mengidentifikasi jenis outfit yang terdeteksi.
                                </p>
                            </div>
                            <!--end::Loading Hint-->
                        </div>
                        <!--end::Submit Section-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Left Card-->
            </div>
            <!--end::Left Panel-->

            <!--begin::Right Panel-->
            <div class="lg:col-span-2">
                <!--begin::Right Card-->
                <div class="panel-card p-6 md:p-8 min-h-[520px]">
                    <!--begin::Preview Header-->
                    <div class="flex items-start gap-4 mb-6">
                        <!--begin::Icon Bubble-->
                        <div class="section-icon-bubble">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#3B6DB4;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <!--end::Icon Bubble-->
                        <!--begin::Title Group-->
                        <div>
                            <!--begin::Title-->
                            <h2 class="section-title">Preview Gambar</h2>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <p class="section-desc mt-1">
                                Setelah gambar dipilih atau foto diambil, atur area outfit secara manual agar hasil analisis AI lebih akurat.
                            </p>
                            <!--end::Description-->
                            <!--begin::Divider-->
                            <div class="theme-divider"></div>
                            <!--end::Divider-->
                        </div>
                        <!--end::Title Group-->
                    </div>
                    <!--end::Preview Header-->

                    <!--begin::Empty State-->
                    <div id="emptyState" class="empty-state-box">
                        <!--begin::Empty State Icon-->
                        <svg class="empty-state-icon" width="80" height="80" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="1" y="1" width="22" height="22" rx="3" ry="3" style="opacity:0.2;"/>
                        </svg>
                        <!--end::Empty State Icon-->
                        <!--begin::Empty State Title-->
                        <p class="empty-state-title">Belum ada gambar dipilih</p>
                        <!--end::Empty State Title-->
                        <!--begin::Empty State Desc-->
                        <p class="empty-state-desc">Preview akan muncul di sini setelah file dipilih atau foto berhasil diambil.</p>
                        <!--end::Empty State Desc-->
                    </div>
                    <!--end::Empty State-->

                    <!--begin::Preview Section-->
                    <div id="previewSection" class="hidden">
                        <!--begin::Preview Wrapper-->
                        <div id="previewWrapper" class="relative inline-block max-w-full">
                            <!--begin::Preview Image-->
                            <img id="previewImage" src="" alt="Preview" class="block max-w-full h-auto">
                            <!--end::Preview Image-->
                            <!--begin::Crop Box-->
                            <div id="cropBox" class="crop-box hidden">
                                <!--begin::Crop Handle-->
                                <div id="cropHandle" class="crop-handle"></div>
                                <!--end::Crop Handle-->
                            </div>
                            <!--end::Crop Box-->
                        </div>
                        <!--end::Preview Wrapper-->

                        <!--begin::Preview Info Grid-->
                        <div class="mt-4 grid sm:grid-cols-2 gap-4">
                            <!--begin::Image Status-->
                            <div class="info-box">
                                <p class="info-box-title">Status gambar</p>
                                <p id="imageStatus" class="info-box-text">Belum ada gambar untuk dianalisis.</p>
                                <span id="statusChip" class="status-chip status-chip-ready hidden">Siap</span>
                            </div>
                            <!--end::Image Status-->
                            <!--begin::Crop Status-->
                            <div class="info-box">
                                <p class="info-box-title">Status crop</p>
                                <p id="cropStatusText" class="info-box-text">
                                    Area di luar kotak crop akan diabaikan saat analisis.
                                </p>
                                <span id="cropStatusChip" class="status-chip status-chip-pending">
                                    Belum diatur
                                </span>
                            </div>
                            <!--end::Crop Status-->
                        </div>
                        <!--end::Preview Info Grid-->
                    </div>
                    <!--end::Preview Section-->
                </div>
                <!--end::Right Card-->
            </div>
            <!--end::Right Panel-->
        </div>
        <!--end::Grid-->
    </main>
    <!--end::Main-->

    <script>
        // Get all necessary DOM elements
        const uploadForm = document.getElementById('uploadForm');
        const submitButton = document.getElementById('submitButton');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        const loadingHint = document.getElementById('loadingHint');

        const imageInput = document.getElementById('imageInput');
        const emptyState = document.getElementById('emptyState');
        const previewSection = document.getElementById('previewSection');
        const previewImage = document.getElementById('previewImage');
        const cropBox = document.getElementById('cropBox');
        const cropHandle = document.getElementById('cropHandle');
        const imageStatus = document.getElementById('imageStatus');
        const statusChip = document.getElementById('statusChip');
        const cropStatusChip = document.getElementById('cropStatusChip');
        const cropStatusText = document.getElementById('cropStatusText');

        const tabUpload = document.getElementById('tabUpload');
        const tabCamera = document.getElementById('tabCamera');
        const tabDevice = document.getElementById('tabDevice');
        const subBtnRow = document.getElementById('subBtnRow');
        const uploadMode = document.getElementById('uploadMode');
        const cameraMode = document.getElementById('cameraMode');

        const cameraVideo = document.getElementById('cameraVideo');
        const cameraCanvas = document.getElementById('cameraCanvas');
        const cameraPlaceholder = document.getElementById('cameraPlaceholder');
        const startCameraBtn = document.getElementById('startCameraBtn');
        const capturePhotoBtn = document.getElementById('capturePhotoBtn');
        const retakePhotoBtn = document.getElementById('retakePhotoBtn');
        const switchCameraBtn = document.getElementById('switchCameraBtn');

        let cameraStream = null;
        let currentFacingMode = 'environment';
        let isDragging = false;
        let isResizing = false;
        let startX = 0;
        let startY = 0;
        let boxX = 0;
        let boxY = 0;
        let boxWidth = 0;
        let boxHeight = 0;
        let isSubmitting = false;

        // Helper: tampilkan sub button row
        function showSubBtnRow() {
            subBtnRow.style.display = 'grid';
        }

        // Helper: sembunyikan sub button row
        function hideSubBtnRow() {
            subBtnRow.style.display = 'none';
        }

        // Helper: cek apakah sub button row sedang tampil
        function isSubBtnRowVisible() {
            return subBtnRow.style.display === 'grid';
        }

        // Helper: set active state on source buttons
        function setActiveSourceBtn(activeBtn) {
            tabUpload.className = 'source-btn-main';
            tabUpload.style.background = '#3B6DB4';
            tabUpload.style.color = '#ffffff';
            [tabCamera, tabDevice].forEach(btn => {
                btn.className = 'source-btn-secondary';
            });
            if (activeBtn === tabCamera) {
                tabCamera.className = 'source-btn-secondary active';
            } else if (activeBtn === tabDevice) {
                tabDevice.className = 'source-btn-secondary active';
            }
        }

        // Functions to switch between modes (Upload)
        // Tombol Unggah berfungsi sebagai toggle: tampilkan/sembunyikan sub buttons
        function switchToUploadMode() {
            if (isSubBtnRowVisible()) {
                // Sembunyikan sub buttons jika sudah terlihat
                hideSubBtnRow();
            } else {
                // Tampilkan sub buttons
                showSubBtnRow();
                uploadMode.classList.add('hidden');
                cameraMode.classList.add('hidden');
            }

            stopCamera();
        }

        // Functions to switch between modes (Camera)
        function switchToCameraMode() {
            // Sembunyikan sub buttons setelah pilihan dibuat
            hideSubBtnRow();
            uploadMode.classList.add('hidden');
            cameraMode.classList.remove('hidden');
            setActiveSourceBtn(tabCamera);
        }

        // Functions to switch between modes (Device - same as upload for now)
        function switchToDeviceMode() {
            // Sembunyikan sub buttons setelah pilihan dibuat
            hideSubBtnRow();
            uploadMode.classList.remove('hidden');
            cameraMode.classList.add('hidden');
            setActiveSourceBtn(tabDevice);
            stopCamera();
            imageInput.click();
        }

        // Event listeners
        tabUpload.addEventListener('click', switchToUploadMode);
        tabCamera.addEventListener('click', switchToCameraMode);
        tabDevice.addEventListener('click', switchToDeviceMode);

        // Render crop box position and size
        function renderCropBox() {
            cropBox.style.left = boxX + 'px';
            cropBox.style.top = boxY + 'px';
            cropBox.style.width = boxWidth + 'px';
            cropBox.style.height = boxHeight + 'px';

            if (cropStatusChip) {
                cropStatusChip.textContent = 'Crop siap';
                cropStatusChip.classList.remove('status-chip-pending');
                cropStatusChip.classList.add('status-chip-ready');
            }

            if (cropStatusText) {
                cropStatusText.textContent =
                    'Area outfit berhasil dipilih dan siap dianalisis.';
            }
        }

        // Show preview from a given image source
        function showPreviewFromSrc(src, sourceLabel = 'Gambar siap dianalisis.') {
            previewImage.src = src;
            emptyState.classList.add('hidden');
            previewSection.classList.remove('hidden');
            imageStatus.textContent = sourceLabel;
            if (statusChip) {
                statusChip.classList.remove('hidden');
            }

            previewImage.onload = function () {
                const width = previewImage.clientWidth;
                const height = previewImage.clientHeight;

                boxWidth = width * 0.45;
                boxHeight = height * 0.6;
                boxX = (width - boxWidth) / 2;
                boxY = (height - boxHeight) / 2;

                cropBox.classList.remove('hidden');
                renderCropBox();
            };
        }

        // Handle file input change
        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                showPreviewFromSrc(e.target.result, 'File berhasil dipilih dan siap dianalisis.');
            };
            reader.readAsDataURL(file);
        });

        // Camera functions
        async function startCamera() {
            try {
                stopCamera();

                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: currentFacingMode
                    },
                    audio: false
                });

                cameraVideo.srcObject = cameraStream;
                cameraVideo.classList.remove('hidden');
                cameraPlaceholder.classList.add('hidden');

                capturePhotoBtn.disabled = false;
                capturePhotoBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                startCameraBtn.innerHTML = `
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="10" y1="15" x2="10" y2="9" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="14" y1="15" x2="14" y2="9" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kamera Aktif
                `;
            } catch (error) {
                alert('Kamera tidak bisa diakses. Pastikan izin kamera sudah diberikan.');
            }
        }

        // Stop camera and release resources
        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }

            cameraVideo.srcObject = null;
        }

        // Event listeners for camera controls
        startCameraBtn.addEventListener('click', async function () {
            await startCamera();
        });

        // Switch camera (front/back)
        switchCameraBtn.addEventListener('click', async function () {
            currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
            await startCamera();
        });

        // Capture photo from video stream
        capturePhotoBtn.addEventListener('click', function () {
            if (!cameraVideo.srcObject) return;

            const width = cameraVideo.videoWidth;
            const height = cameraVideo.videoHeight;

            cameraCanvas.width = width;
            cameraCanvas.height = height;

            const ctx = cameraCanvas.getContext('2d');
            ctx.drawImage(cameraVideo, 0, 0, width, height);

            cameraCanvas.toBlob(function (blob) {
                if (!blob) return;

                const file = new File([blob], 'camera-capture.png', { type: 'image/png' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                const croppedInput = document.getElementById('cropped_image');
                croppedInput.value =
                    cameraCanvas.toDataURL(
                        'image/webp',
                        0.6
                    );

                const previewUrl = URL.createObjectURL(blob);
                showPreviewFromSrc(previewUrl, 'Foto dari kamera berhasil diambil dan siap dianalisis.');

                retakePhotoBtn.classList.remove('hidden');
                stopCamera();

                cameraVideo.classList.add('hidden');
                cameraPlaceholder.classList.remove('hidden');
                cameraPlaceholder.innerHTML = `
                    <div>
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#A8C4E8; margin:0 auto 8px;">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="22 4 12 14.01 9 11.01" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Foto berhasil diambil</p>
                        <p class="text-xs text-gray-500 mt-1">Preview foto sudah masuk ke sistem dan bisa langsung di-crop.</p>
                    </div>
                `;

                startCameraBtn.innerHTML = `
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="5 3 19 12 5 21 5 3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Mulai Kamera
                `;
            }, 'image/png');
        });

        // Retake photo - reset to camera preview
        retakePhotoBtn.addEventListener('click', async function () {
            cameraPlaceholder.innerHTML = `
                <div>
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#A8C4E8; margin:0 auto 8px;">
                        <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="13" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-700">Kamera belum aktif</p>
                    <p class="text-xs text-gray-500 mt-1">Klik tombol mulai kamera untuk menampilkan preview kamera.</p>
                </div>
            `;
            await startCamera();
        });

        // Crop box event listeners
        cropBox.addEventListener('mousedown', function (e) {
            if (isSubmitting) return;
            if (e.target === cropHandle) return;

            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            e.preventDefault();
        });

        // Resize handle event listener
        cropHandle.addEventListener('mousedown', function (e) {
            if (isSubmitting) return;

            isResizing = true;
            startX = e.clientX;
            startY = e.clientY;
            e.stopPropagation();
            e.preventDefault();
        });

        // Mouse move event for dragging and resizing
        document.addEventListener('mousemove', function (e) {
            const maxWidth = previewImage.clientWidth;
            const maxHeight = previewImage.clientHeight;

            // Dragging the crop box
            if (isDragging) {
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;

                boxX = Math.max(0, Math.min(boxX + dx, maxWidth - boxWidth));
                boxY = Math.max(0, Math.min(boxY + dy, maxHeight - boxHeight));

                startX = e.clientX;
                startY = e.clientY;
                renderCropBox();
            }

            // Resizing the crop box
            if (isResizing) {
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;

                boxWidth = Math.max(60, Math.min(boxWidth + dx, maxWidth - boxX));
                boxHeight = Math.max(60, Math.min(boxHeight + dy, maxHeight - boxY));

                startX = e.clientX;
                startY = e.clientY;
                renderCropBox();
            }
        });

        // Mouse up event to stop dragging/resizing
        document.addEventListener('mouseup', function () {
            isDragging = false;
            isResizing = false;
        });

        // Function to send form data via AJAX
        async function sendFormData(formData) {
            try {
                const response = await fetch(
                    uploadForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content
                        }
                    }
                );

                const html = await response.text();
                document.open();
                document.write(html);
                document.close();

            } catch(error) {
                console.error(error);
                alert(error);

                isSubmitting = false;
                submitButton.disabled = false;
                submitSpinner.classList.add('hidden');
                loadingHint.classList.add('hidden');
                submitText.textContent = 'Analisis Gambar';
            }
        }

        // Form submission handler
        uploadForm.addEventListener('submit', async function (e) {

            e.preventDefault();

            if (isSubmitting) {
                return;
            }

            const isCameraMode = !cameraMode.classList.contains('hidden');
            const hasCameraImage = document.getElementById('cropped_image').value !== '';

            if (!imageInput.files.length && !(isCameraMode && hasCameraImage)) {
                alert('Pilih gambar dulu');
                return;
            }

            isSubmitting = true;

            submitButton.disabled = true;

            submitSpinner.classList.remove('hidden');

            submitText.textContent =
                'Sedang menganalisis...';

            loadingHint.classList.remove('hidden');

            const canvas = document.createElement('canvas');
            const scaleX = previewImage.naturalWidth ? previewImage.naturalWidth / previewImage.clientWidth : 1;
            const scaleY = previewImage.naturalHeight ? previewImage.naturalHeight / previewImage.clientHeight : 1;
            const cropX = parseFloat(cropBox.style.left);
            const cropY = parseFloat(cropBox.style.top);
            const cropWidth = cropBox.offsetWidth;
            const cropHeight = cropBox.offsetHeight;

            canvas.width = cropWidth * scaleX;
            canvas.height = cropHeight * scaleY;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(
                previewImage,

                cropX * scaleX,
                cropY * scaleY,

                cropWidth * scaleX,
                cropHeight * scaleY,

                0,
                0,

                canvas.width,
                canvas.height
            );

            // Convert canvas crop to Blob and send via AJAX
            canvas.toBlob(async function(blob) {
                const formData = new FormData();
                const isCameraMode = !cameraMode.classList.contains('hidden');

                // If in camera mode, we need to send both the original image (from camera) and the cropped image (from canvas)
                if (isCameraMode) {
                    cameraCanvas.toBlob(function(originalBlob) {
                        const originalFile = new File([originalBlob], 'camera-original.webp', { type: 'image/webp' });
                        formData.append('image', originalFile);
                        formData.append('original_image', originalFile);

                        // Cropped image dari canvas crop
                        const croppedFile = new File([blob], 'camera-cropped.webp', { type: 'image/webp' });
                        formData.append('cropped_image', canvas.toDataURL('image/webp', 0.6));

                        // Kirim form
                        sendFormData(formData);
                    }, 'image/webp', 0.8);
                }
                // If in upload mode, we can send the original file from input and the cropped image from canvas
                else {
                    formData.append('original_image', imageInput.files[0]);
                    formData.append('image', imageInput.files[0]);
                    formData.append('cropped_image', canvas.toDataURL('image/webp', 0.6));

                    sendFormData(formData);
                }

            }, 'image/webp', 0.5);
        });
    </script>
</body>
</html>
