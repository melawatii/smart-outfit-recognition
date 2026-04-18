<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Outfit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Crimson+Text:wght@400;600;700&family=EB+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        .crop-box {
            position: absolute;
            border: 2px solid #E87F24;
            background: rgba(255, 200, 30, 0.16);
            cursor: move;
            box-shadow: 0 0 0 9999px rgba(17, 24, 39, 0.35);
            border-radius: 16px;
        }

        .crop-handle {
            position: absolute;
            width: 14px;
            height: 14px;
            right: -7px;
            bottom: -7px;
            background: #73A5CA;
            border: 2px solid #ffffff;
            border-radius: 9999px;
            cursor: nwse-resize;
        }

        .spinner {
            width: 22px;
            height: 22px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 9999px;
            animation: spin 0.8s linear infinite;
        }

        .camera-btn-secondary {
            border: 1px solid #FFC81E;
            background: #FEFDDF;
            color: #374151;
        }

        .camera-btn-secondary:hover {
            background: #FFF7CC;
            border-color: #E87F24;
            color: #E87F24;
        }

        .camera-btn-dark {
            background: #E87F24;
            color: white;
        }

        .camera-btn-dark:hover {
            background: #FFC81E;
            color: #1f2937;
        }

        .panel-card {
            background: rgba(255,255,255,0.92);
            border: 1px solid #FFC81E;
            border-radius: 24px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }

        .soft-box {
            background-color: #FFFDF4;
            border: 1px solid #F3D66B;
            border-radius: 18px;
        }

        .blue-box {
            background-color: #EEF6FC;
            border: 1px solid #73A5CA;
            border-radius: 18px;
        }

        .yellow-box {
            background-color: #FFF7CC;
            border: 1px solid #FFC81E;
            border-radius: 18px;
        }

        .theme-btn-primary {
            background-color: #E87F24;
            color: white;
            transition: all 0.3s ease;
        }

        .theme-btn-primary:hover {
            background-color: #FFC81E;
            color: #1f2937;
        }

        .theme-link {
            color: #73A5CA;
            transition: color 0.3s ease;
        }

        .theme-link:hover {
            color: #E87F24;
        }

        .theme-divider {
            height: 4px;
            width: 80px;
            border-radius: 9999px;
            background: linear-gradient(to right, #E87F24, #FFC81E, #73A5CA);
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="min-h-screen text-gray-800 font-body" style="background-color:#FEFDDF;">
    <!--begin::Header-->
    <header class="sticky top-0 z-50 backdrop-blur border-b" style="background-color:rgba(254,253,223,0.92); border-color:#FFC81E;">
        <!--begin::Container-->
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <!--begin::Brand-->
            <div>
                <!--begin::Brand Title-->
                <h1 class="text-lg font-title tracking-wide">
                    <!--begin::Brand Primary-->
                    <span style="color:#73A5CA;">Upload</span>
                    <!--end::Brand Primary-->
                    <!--begin::Brand Secondary-->
                    <span style="color:#E87F24;">Outfit</span>
                    <!--end::Brand Secondary-->
                </h1>
                <!--end::Brand Title-->
            </div>
            <!--end::Brand-->
            <!--begin::Back Link-->
            <a href="{{ route('home') }}" class="text-sm font-elegant theme-link inline-flex items-center gap-2">
                <!--begin::Back Link Icon-->
                <span>←</span>
                <!--end::Back Link Icon-->
                <!--begin::Back Link Text-->
                <span>Kembali ke Home</span>
                <!--end::Back Link Text-->
            </a>
            <!--end::Back Link-->
        </div>
        <!--end::Container-->
    </header>
    <!--end::Header-->

    <!--begin::Main-->
    <main class="max-w-6xl mx-auto px-6 py-10">
        <!--begin::Grid-->
        <div class="grid lg:grid-cols-3 gap-8">
            <!--begin::Left Panel-->
            <div class="lg:col-span-1">
                <!--begin::Left Card-->
                <div class="panel-card p-6">
                    <!--begin::Section Header-->
                    <div class="mb-6">
                        <!--begin::Title-->
                        <h2 class="text-xl font-elegant font-semibold mb-2" style="color:#E87F24;">
                            Input Gambar
                        </h2>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Pilih sumber gambar terlebih dahulu, lalu siapkan area outfit agar proses analisis warna menjadi lebih akurat.
                        </p>
                        <!--end::Description-->
                        <!--begin::Divider-->
                        <div class="mt-3 theme-divider"></div>
                        <!--end::Divider-->

                    </div>
                    <!--end::Section Header-->
                    @if ($errors->any())
                        <!--begin::Error Alert-->
                        <div class="mb-5 rounded-2xl p-4 text-sm" style="background:#fff1f2; border:1px solid #fda4af; color:#be123c;">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!--end::Error Alert-->
                    @endif
                    <!--begin::Form-->
                    <form id="uploadForm" action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <!--begin::Source Picker-->
                        <div class="soft-box p-4">
                            <!--begin::Step Title-->
                            <p class="text-sm font-medium mb-3" style="color:#374151;">
                                1. Pilih sumber gambar
                            </p>
                            <!--end::Step Title-->
                            <!--begin::Main Button-->
                            <button type="button" id="openSourcePickerBtn" class="w-full px-4 py-3 rounded-2xl text-sm font-medium theme-btn-primary">
                                Upload
                            </button>
                            <!--end::Main Button-->
                            <!--begin::Options-->
                            <div id="sourcePicker" class="hidden mt-3 grid grid-cols-2 gap-3">
                                <!--begin::Camera Btn-->
                                <button type="button" id="tabCamera" class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition">
                                    Gunakan Kamera
                                </button>
                                <!--end::Camera Btn-->
                                <!--begin::Upload Btn-->
                                <button type="button" id="tabUpload" class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition">
                                    Pilih dari Komputer
                                </button>
                                <!--end::Upload Btn-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Source Picker-->
                        <!--begin::Upload Mode-->
                        <div id="uploadMode" class="hidden space-y-3">
                            <!--begin::File Input-->
                            <div>
                                <!--begin::File Label-->
                                <label class="block text-sm font-medium mb-2" style="color:#374151;">
                                    2. Pilih file gambar
                                </label>
                                <!--end::File Label-->
                                <!--begin::File Control-->
                                <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png" class="block w-full rounded-2xl px-4 py-3" style="background-color:#FFFDF4; border:1px solid #F3D66B;">
                                <!--end::File Control-->
                            </div>
                            <!--end::File Input-->
                            <!--begin::Tips-->
                            <div class="yellow-box p-4">
                                <!--begin::Tips Title-->
                                <p class="text-sm font-medium mb-1" style="color:#9a6700;">Saran</p>
                                <!--end::Tips Title-->
                                <!--begin::Tips Text-->
                                <p class="text-sm" style="color:#7c5a00;">
                                    Gunakan foto yang fokus ke outfit agar warna yang dianalisis tidak tercampur dengan background.
                                </p>
                                <!--end::Tips Text-->
                            </div>
                            <!--end::Tips-->
                        </div>
                        <!--end::Upload Mode-->
                        <!--begin::Camera Mode-->
                        <div id="cameraMode" class="hidden space-y-4">
                            <!--begin::Camera Preview-->
                            <div class="soft-box p-3">
                                <!--begin::Video-->
                                <video id="cameraVideo" autoplay playsinline class="w-full rounded-2xl bg-black hidden"></video>
                                <!--end::Video-->
                                <!--begin::Canvas-->
                                <canvas id="cameraCanvas" class="hidden"></canvas>
                                <!--end::Canvas-->
                                <!--begin::Placeholder-->
                                <div id="cameraPlaceholder" class="h-56 rounded-2xl border border-dashed flex items-center justify-center text-center bg-white" style="border-color:#73A5CA;">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Kamera belum aktif</p>
                                        <p class="text-xs text-gray-500 mt-1">Klik tombol mulai kamera untuk menampilkan preview kamera.</p>
                                    </div>
                                </div>
                                <!--end::Placeholder-->
                            </div>
                            <!--end::Camera Preview-->
                            <!--begin::Camera Controls-->
                            <div class="soft-box p-4">
                                <!--begin::Step Title-->
                                <p class="text-sm font-medium mb-3" style="color:#374151;">2. Kontrol kamera</p>
                                <!--end::Step Title-->
                                <!--begin::Primary Controls-->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <!--begin::Start Camera Button-->
                                    <button type="button" id="startCameraBtn" class="px-4 py-3 rounded-2xl camera-btn-dark text-sm font-medium transition">
                                        Mulai Kamera
                                    </button>
                                    <!--end::Start Camera Button-->
                                    <!--begin::Capture Button-->
                                    <button type="button" id="capturePhotoBtn" class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition opacity-50 cursor-not-allowed" disabled>
                                        Ambil Foto
                                    </button>
                                    <!--end::Capture Button-->
                                </div>
                                <!--end::Primary Controls-->
                                <!--begin::Secondary Controls-->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                                    <!--begin::Switch Camera Button-->
                                    <button type="button" id="switchCameraBtn" class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition">
                                        Ganti Kamera
                                    </button>
                                    <!--end::Switch Camera Button-->
                                    <!--begin::Retake Button-->
                                    <button type="button" id="retakePhotoBtn" class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition hidden">
                                        Ambil Ulang
                                    </button>
                                    <!--end::Retake Button-->
                                </div>
                                <!--end::Secondary Controls-->
                            </div>
                            <!--end::Camera Controls-->
                            <!--begin::Camera Guide-->
                            <div class="blue-box p-4">
                                <!--begin::Guide Title-->
                                <p class="text-sm font-medium mb-1" style="color:#1e3a5f;">Alur penggunaan kamera</p>
                                <!--end::Guide Title-->
                                <!--begin::Guide List-->
                                <ol class="text-sm space-y-1 list-decimal list-inside" style="color:#315d89;">
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
                        <!--begin::Hidden Inputs-->
                        <input type="hidden" name="crop_x" id="crop_x">
                        <input type="hidden" name="crop_y" id="crop_y">
                        <input type="hidden" name="crop_width" id="crop_width">
                        <input type="hidden" name="crop_height" id="crop_height">
                        <input type="hidden" name="display_width" id="display_width">
                        <input type="hidden" name="display_height" id="display_height">
                        <!--end::Hidden Inputs-->
                        <!--begin::Crop Instruction-->
                        <div class="soft-box p-4">
                            <!--begin::Step Title-->
                            <p class="text-sm font-medium mb-2" style="color:#374151;">3. Atur area crop</p>
                            <!--end::Step Title-->
                            <!--begin::Instruction List-->
                            <ul class="text-sm text-gray-600 space-y-1 leading-relaxed">
                                <li>• Geser kotak crop ke area pakaian.</li>
                                <li>• Tarik titik kanan bawah untuk memperbesar atau memperkecil area.</li>
                                <li>• Area di luar kotak crop tidak akan dianalisis.</li>
                            </ul>
                            <!--end::Instruction List-->
                        </div>
                        <!--end::Crop Instruction-->
                        <!--begin::Submit Section-->
                        <div>
                            <!--begin::Submit Button-->
                            <button type="submit" id="submitButton" class="w-full px-5 py-3 rounded-2xl font-medium transition flex items-center justify-center gap-3 theme-btn-primary">
                                <span id="submitText">Analisis Gambar</span>
                                <span id="submitSpinner" class="spinner hidden"></span>
                            </button>
                            <!--end::Submit Button-->
                            <!--begin::Loading Hint-->
                            <div id="loadingHint" class="hidden blue-box p-4 mt-3">
                                <p class="text-sm font-medium mb-1" style="color:#1e3a5f;">AI sedang menganalisis gambar</p>
                                <p class="text-sm" style="color:#315d89;">
                                    Mohon tunggu beberapa saat. Sistem sedang memproses area crop, membaca palette warna, dan menyusun rekomendasi outfit.
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
                    <div class="mb-6">
                        <!--begin::Title-->
                        <h2 class="text-xl font-elegant font-semibold" style="color:#E87F24;">
                            Preview Gambar
                        </h2>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <p class="text-sm text-gray-600 mt-1">
                            Setelah gambar dipilih atau foto diambil, atur area outfit secara manual agar hasil analisis AI lebih akurat.
                        </p>
                        <!--end::Description-->
                        <!--begin::Divider-->
                        <div class="mt-3 theme-divider"></div>
                        <!--end::Divider-->
                    </div>
                    <!--end::Preview Header-->
                    <!--begin::Empty State-->
                    <div id="emptyState" class="p-5 h-[420px] rounded-3xl border border-dashed flex items-center justify-center text-center" style="border-color:#73A5CA; background-color:#FFFDF4;">
                        <div>
                            <p class="text-lg font-medium text-gray-700">Belum ada gambar dipilih</p>
                            <p class="text-sm text-gray-500 mt-2">Preview akan muncul di sini setelah file dipilih atau foto berhasil diambil.</p>
                        </div>
                    </div>
                    <!--end::Empty State-->
                    <!--begin::Preview Section-->
                    <div id="previewSection" class="hidden">
                        <!--begin::Preview Wrapper-->
                        <div id="previewWrapper" class="relative inline-block max-w-full border rounded-3xl overflow-hidden" style="border-color:#FFC81E; background-color:#FFFDF4;">
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
                            <div class="soft-box p-4">
                                <p class="text-sm font-medium mb-1" style="color:#374151;">Status gambar</p>
                                <p id="imageStatus" class="text-sm text-gray-600">Belum ada gambar untuk dianalisis.</p>
                            </div>
                            <!--end::Image Status-->
                            <!--begin::Crop Status-->
                            <div class="soft-box p-4">
                                <p class="text-sm font-medium mb-1" style="color:#374151;">Status crop</p>
                                <p class="text-sm text-gray-600">Area di luar kotak crop akan diabaikan saat analisis.</p>
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

        const cropXInput = document.getElementById('crop_x');
        const cropYInput = document.getElementById('crop_y');
        const cropWidthInput = document.getElementById('crop_width');
        const cropHeightInput = document.getElementById('crop_height');
        const displayWidthInput = document.getElementById('display_width');
        const displayHeightInput = document.getElementById('display_height');

        const openSourcePickerBtn = document.getElementById('openSourcePickerBtn');
        const sourcePicker = document.getElementById('sourcePicker');
        const tabUpload = document.getElementById('tabUpload');
        const tabCamera = document.getElementById('tabCamera');
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

        // Functions to switch between modes (Upload)
        function switchToUploadMode() {
            sourcePicker.classList.remove('hidden');
            uploadMode.classList.remove('hidden');
            cameraMode.classList.add('hidden');

            tabUpload.className = 'px-4 py-3 rounded-2xl text-white text-sm font-medium transition';
            tabUpload.style.backgroundColor = '#E87F24';

            tabCamera.className = 'px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition';
            tabCamera.style.backgroundColor = '';
            tabCamera.style.color = '';
            tabCamera.style.borderColor = '';

            stopCamera();
        }

        // Functions to switch between modes (Camera)
        function switchToCameraMode() {
            sourcePicker.classList.remove('hidden');
            uploadMode.classList.add('hidden');
            cameraMode.classList.remove('hidden');

            tabCamera.className = 'px-4 py-3 rounded-2xl text-white text-sm font-medium transition';
            tabCamera.style.backgroundColor = '#E87F24';

            tabUpload.className = 'px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition';
            tabUpload.style.backgroundColor = '';
            tabUpload.style.color = '';
            tabUpload.style.borderColor = '';
        }

        // Event listeners
        openSourcePickerBtn.addEventListener('click', function () {
            sourcePicker.classList.remove('hidden');
        });

        // Default to upload mode on page load
        tabUpload.addEventListener('click', switchToUploadMode);
        tabCamera.addEventListener('click', switchToCameraMode);

        // Crop box functions
        function updateCropInputs() {
            cropXInput.value = boxX;
            cropYInput.value = boxY;
            cropWidthInput.value = boxWidth;
            cropHeightInput.value = boxHeight;
            displayWidthInput.value = previewImage.clientWidth;
            displayHeightInput.value = previewImage.clientHeight;
        }

        // Render crop box position and size
        function renderCropBox() {
            cropBox.style.left = boxX + 'px';
            cropBox.style.top = boxY + 'px';
            cropBox.style.width = boxWidth + 'px';
            cropBox.style.height = boxHeight + 'px';
            updateCropInputs();
        }

        // Show preview from a given image source
        function showPreviewFromSrc(src, sourceLabel = 'Gambar siap dianalisis.') {
            previewImage.src = src;
            emptyState.classList.add('hidden');
            previewSection.classList.remove('hidden');
            imageStatus.textContent = sourceLabel;

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

                startCameraBtn.textContent = 'Kamera Aktif';
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
                imageInput.files = dataTransfer.files;

                const previewUrl = URL.createObjectURL(blob);
                showPreviewFromSrc(previewUrl, 'Foto dari kamera berhasil diambil dan siap dianalisis.');

                retakePhotoBtn.classList.remove('hidden');
                stopCamera();

                cameraVideo.classList.add('hidden');
                cameraPlaceholder.classList.remove('hidden');
                cameraPlaceholder.innerHTML = `
                    <div>
                        <p class="text-sm font-medium text-gray-700">Foto berhasil diambil</p>
                        <p class="text-xs text-gray-500 mt-1">Preview foto sudah masuk ke sistem dan bisa langsung di-crop.</p>
                    </div>
                `;

                startCameraBtn.textContent = 'Mulai Kamera';
            }, 'image/png');
        });

        // Retake photo - reset to camera preview
        retakePhotoBtn.addEventListener('click', async function () {
            cameraPlaceholder.innerHTML = `
                <div>
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

        // Form submission handler
        uploadForm.addEventListener('submit', function (e) {
            // Prevent multiple submissions
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            // Validate that an image has been selected
            if (!imageInput.files.length) {
                alert('Pilih gambar atau ambil foto dulu.');
                e.preventDefault();
                return;
            }

            isSubmitting = true;
            submitButton.disabled = true;
            submitButton.classList.add('opacity-80', 'cursor-not-allowed');
            submitText.textContent = 'Sedang menganalisis...';
            submitSpinner.classList.remove('hidden');
            loadingHint.classList.remove('hidden');
            stopCamera();
        });

        // Clean up camera stream when navigating away
        window.addEventListener('beforeunload', function () {
            stopCamera();
        });

        // Initialize page with upload mode active
        uploadMode.classList.add('hidden');
        cameraMode.classList.add('hidden');
        sourcePicker.classList.add('hidden');
    </script>
</body>
</html>