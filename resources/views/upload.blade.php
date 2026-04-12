<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Outfit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .crop-box {
            position: absolute;
            border: 2px solid #111827;
            background: rgba(255,255,255,0.18);
            cursor: move;
            box-shadow: 0 0 0 9999px rgba(0,0,0,0.18);
        }

        .crop-handle {
            position: absolute;
            width: 14px;
            height: 14px;
            right: -7px;
            bottom: -7px;
            background: #111827;
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
            border: 1px solid #d6d3d1;
            background: #f5f5f4;
            color: #1f2937;
        }

        .camera-btn-secondary:hover {
            background: #e7e5e4;
        }

        .camera-btn-dark {
            background: #111827;
            color: white;
        }

        .camera-btn-dark:hover {
            background: #000000;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-stone-50 min-h-screen text-gray-800">

<header class="border-b border-stone-200 bg-white/90 backdrop-blur">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold">Upload Outfit</h1>
            <p class="text-xs text-gray-500">Pilih gambar atau kamera, lalu tentukan area outfit yang ingin dianalisis</p>
        </div>

        <a href="{{ route('home') }}"
           class="text-sm text-gray-600 hover:text-black transition">
            ← Kembali ke Home
        </a>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-10">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Panel kiri -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-2">Input Gambar</h2>
                <p class="text-sm text-gray-600 leading-relaxed mb-6">
                    Pilih sumber gambar terlebih dahulu, lalu siapkan area outfit agar proses analisis warna menjadi lebih akurat.
                </p>

                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="uploadForm" action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Pilihan awal -->
                    <div class="rounded-2xl border border-stone-200 p-4 bg-stone-50">
                        <p class="text-sm font-medium mb-3">1. Pilih sumber gambar</p>

                        <button
                            type="button"
                            id="openSourcePickerBtn"
                            class="w-full px-4 py-3 rounded-2xl bg-stone-900 text-white text-sm font-medium transition hover:bg-black"
                        >
                            Upload
                        </button>

                        <div id="sourcePicker" class="hidden mt-3 grid grid-cols-2 gap-3">
                            <button
                                type="button"
                                id="tabCamera"
                                class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition"
                            >
                                Gunakan Kamera
                            </button>

                            <button
                                type="button"
                                id="tabUpload"
                                class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition"
                            >
                                Pilih dari Komputer
                            </button>
                        </div>
                    </div>

                    <!-- Upload file -->
                    <div id="uploadMode" class="hidden space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-2">File gambar</label>
                            <input
                                type="file"
                                name="image"
                                id="imageInput"
                                accept=".jpg,.jpeg,.png"
                                class="block w-full border border-stone-300 rounded-2xl px-4 py-3 bg-stone-50"
                            >
                        </div>

                        <div class="rounded-2xl bg-amber-50 border border-amber-200 p-4">
                            <p class="text-sm font-medium text-amber-900 mb-1">Saran</p>
                            <p class="text-sm text-amber-800">
                                Gunakan foto yang fokus ke outfit agar warna yang dianalisis tidak tercampur dengan background.
                            </p>
                        </div>
                    </div>

                    <!-- Kamera -->
                    <div id="cameraMode" class="hidden space-y-4">
                        <div class="rounded-2xl border border-stone-200 bg-stone-50 p-3">
                            <video id="cameraVideo" autoplay playsinline class="w-full rounded-2xl bg-black hidden"></video>
                            <canvas id="cameraCanvas" class="hidden"></canvas>

                            <div id="cameraPlaceholder" class="h-56 rounded-2xl border border-dashed border-stone-300 flex items-center justify-center text-center bg-white">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Kamera belum aktif</p>
                                    <p class="text-xs text-gray-500 mt-1">Klik tombol mulai kamera untuk menampilkan preview kamera.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-stone-200 bg-stone-50 p-4">
                            <p class="text-sm font-medium mb-3">2. Kontrol kamera</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <button
                                    type="button"
                                    id="startCameraBtn"
                                    class="px-4 py-3 rounded-2xl camera-btn-dark text-sm font-medium transition"
                                >
                                    Mulai Kamera
                                </button>

                                <button
                                    type="button"
                                    id="capturePhotoBtn"
                                    class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition opacity-50 cursor-not-allowed"
                                    disabled
                                >
                                    Ambil Foto
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                                <button
                                    type="button"
                                    id="switchCameraBtn"
                                    class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition"
                                >
                                    Ganti Kamera
                                </button>

                                <button
                                    type="button"
                                    id="retakePhotoBtn"
                                    class="px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition hidden"
                                >
                                    Ambil Ulang
                                </button>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-blue-50 border border-blue-200 p-4">
                            <p class="text-sm font-medium text-blue-900 mb-1">Alur penggunaan kamera</p>
                            <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                                <li>Klik <strong>Mulai Kamera</strong></li>
                                <li>Arahkan kamera ke outfit</li>
                                <li>Klik <strong>Ambil Foto</strong></li>
                                <li>Atur area crop pada preview</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Hidden inputs -->
                    <input type="hidden" name="crop_x" id="crop_x">
                    <input type="hidden" name="crop_y" id="crop_y">
                    <input type="hidden" name="crop_width" id="crop_width">
                    <input type="hidden" name="crop_height" id="crop_height">
                    <input type="hidden" name="display_width" id="display_width">
                    <input type="hidden" name="display_height" id="display_height">

                    <!-- Petunjuk crop -->
                    <div class="rounded-2xl bg-stone-50 border border-stone-200 p-4">
                        <p class="text-sm font-medium mb-2">3. Atur area crop</p>
                        <ul class="text-sm text-gray-600 space-y-1 leading-relaxed">
                            <li>• Geser kotak crop ke area pakaian.</li>
                            <li>• Tarik titik kanan bawah untuk memperbesar atau memperkecil area.</li>
                            <li>• Area di luar kotak crop tidak akan dianalisis.</li>
                        </ul>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        id="submitButton"
                        class="w-full px-5 py-3 rounded-2xl bg-stone-900 text-white font-medium hover:bg-black transition flex items-center justify-center gap-3"
                    >
                        <span id="submitText">Analisis Gambar</span>
                        <span id="submitSpinner" class="spinner hidden"></span>
                    </button>

                    <div id="loadingHint" class="hidden rounded-2xl bg-blue-50 border border-blue-200 p-4">
                        <p class="text-sm font-medium text-blue-900 mb-1">AI sedang menganalisis gambar</p>
                        <p class="text-sm text-blue-700">
                            Mohon tunggu beberapa saat. Sistem sedang memproses area crop, membaca palette warna, dan menyusun rekomendasi outfit.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel kanan -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-stone-200 rounded-3xl shadow-sm p-6 md:p-8 min-h-[520px]">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold">Preview Gambar</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Setelah gambar dipilih atau foto diambil, atur area outfit secara manual agar hasil analisis AI lebih akurat.
                    </p>
                </div>

                <div id="emptyState" class="h-[420px] rounded-3xl border border-dashed border-stone-300 bg-stone-50 flex items-center justify-center text-center">
                    <div>
                        <p class="text-lg font-medium text-gray-700">Belum ada gambar dipilih</p>
                        <p class="text-sm text-gray-500 mt-2">Preview akan muncul di sini setelah file dipilih atau foto berhasil diambil.</p>
                    </div>
                </div>

                <div id="previewSection" class="hidden">
                    <div id="previewWrapper" class="relative inline-block max-w-full border border-stone-200 rounded-3xl overflow-hidden bg-stone-50">
                        <img id="previewImage" src="" alt="Preview" class="block max-w-full h-auto">
                        <div id="cropBox" class="crop-box hidden">
                            <div id="cropHandle" class="crop-handle"></div>
                        </div>
                    </div>

                    <div class="mt-4 grid sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-stone-50 border border-stone-200 p-4">
                            <p class="text-sm font-medium mb-1">Status gambar</p>
                            <p id="imageStatus" class="text-sm text-gray-600">Belum ada gambar untuk dianalisis.</p>
                        </div>

                        <div class="rounded-2xl bg-stone-50 border border-stone-200 p-4">
                            <p class="text-sm font-medium mb-1">Status crop</p>
                            <p class="text-sm text-gray-600">Area di luar kotak crop akan diabaikan saat analisis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
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

    function switchToUploadMode() {
        sourcePicker.classList.remove('hidden');
        uploadMode.classList.remove('hidden');
        cameraMode.classList.add('hidden');

        tabUpload.className = 'px-4 py-3 rounded-2xl bg-stone-900 text-white text-sm font-medium transition';
        tabCamera.className = 'px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition';

        stopCamera();
    }

    function switchToCameraMode() {
        sourcePicker.classList.remove('hidden');
        uploadMode.classList.add('hidden');
        cameraMode.classList.remove('hidden');

        tabCamera.className = 'px-4 py-3 rounded-2xl bg-stone-900 text-white text-sm font-medium transition';
        tabUpload.className = 'px-4 py-3 rounded-2xl camera-btn-secondary text-sm font-medium transition';
    }

    openSourcePickerBtn.addEventListener('click', function () {
        sourcePicker.classList.remove('hidden');
    });

    tabUpload.addEventListener('click', switchToUploadMode);
    tabCamera.addEventListener('click', switchToCameraMode);

    function updateCropInputs() {
        cropXInput.value = boxX;
        cropYInput.value = boxY;
        cropWidthInput.value = boxWidth;
        cropHeightInput.value = boxHeight;
        displayWidthInput.value = previewImage.clientWidth;
        displayHeightInput.value = previewImage.clientHeight;
    }

    function renderCropBox() {
        cropBox.style.left = boxX + 'px';
        cropBox.style.top = boxY + 'px';
        cropBox.style.width = boxWidth + 'px';
        cropBox.style.height = boxHeight + 'px';
        updateCropInputs();
    }

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

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            showPreviewFromSrc(e.target.result, 'File berhasil dipilih dan siap dianalisis.');
        };
        reader.readAsDataURL(file);
    });

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

    function stopCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }

        cameraVideo.srcObject = null;
    }

    startCameraBtn.addEventListener('click', async function () {
        await startCamera();
    });

    switchCameraBtn.addEventListener('click', async function () {
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        await startCamera();
    });

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

    retakePhotoBtn.addEventListener('click', async function () {
        cameraPlaceholder.innerHTML = `
            <div>
                <p class="text-sm font-medium text-gray-700">Kamera belum aktif</p>
                <p class="text-xs text-gray-500 mt-1">Klik tombol mulai kamera untuk menampilkan preview kamera.</p>
            </div>
        `;
        await startCamera();
    });

    cropBox.addEventListener('mousedown', function (e) {
        if (isSubmitting) return;
        if (e.target === cropHandle) return;

        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        e.preventDefault();
    });

    cropHandle.addEventListener('mousedown', function (e) {
        if (isSubmitting) return;

        isResizing = true;
        startX = e.clientX;
        startY = e.clientY;
        e.stopPropagation();
        e.preventDefault();
    });

    document.addEventListener('mousemove', function (e) {
        const maxWidth = previewImage.clientWidth;
        const maxHeight = previewImage.clientHeight;

        if (isDragging) {
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            boxX = Math.max(0, Math.min(boxX + dx, maxWidth - boxWidth));
            boxY = Math.max(0, Math.min(boxY + dy, maxHeight - boxHeight));

            startX = e.clientX;
            startY = e.clientY;
            renderCropBox();
        }

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

    document.addEventListener('mouseup', function () {
        isDragging = false;
        isResizing = false;
    });

    uploadForm.addEventListener('submit', function (e) {
        if (isSubmitting) {
            e.preventDefault();
            return;
        }

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

    window.addEventListener('beforeunload', function () {
        stopCamera();
    });

    uploadMode.classList.add('hidden');
    cameraMode.classList.add('hidden');
    sourcePicker.classList.add('hidden');
</script>

</body>
</html>