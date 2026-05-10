                                                                                                                                                                                                                                                                                                                                                                 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ambil Foto - Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guest-form.css') }}">
</head>
<body class="guest-form-body">

    @include('layouts.navbar')

    <div class="main-content-form">
        <div class="step-container">
            <h2 class="step-title">Step 2 of 3</h2>

            <div class="progress-wrapper">
                <div class="progress-bar-container">
                    <div class="progress-bar-segment active"></div>
                    <div class="progress-bar-segment active"></div>
                    <div class="progress-bar-segment"></div>
                </div>
            </div>
        </div>

        <div class="form-card photo-card">
            <h1 class="form-card-title">Ambil Foto</h1>

            <div class="camera-preview" id="cameraPreview">
                <video id="cameraVideo" autoplay playsinline muted></video>
                <canvas id="snapshotCanvas" style="display: none;"></canvas>
                <div class="camera-fallback" id="cameraFallback">Kamera tidak tersedia</div>

                <!-- Camera Controls -->
                <div class="camera-controls" id="cameraControls">
                    <button type="button" id="retryBtn" class="camera-btn camera-btn-secondary">
                        <img src="{{ asset('img/ulang foto.svg') }}" alt="Ulang Foto" class="camera-icon">
                    </button>

                    <button type="button" id="shutterBtn" class="camera-btn camera-btn-shutter" title="Jepret Foto">
                        <span class="shutter-ring outer"></span>
                        <span class="shutter-ring middle"></span>
                        <span class="shutter-ring inner">
                            <img src="{{ asset('img/Foto.svg') }}" alt="Jepret" class="shutter-icon">
                        </span>
                    </button>

                    <button type="button" id="flashBtn" class="camera-btn camera-btn-flash" title="Flash">
                        <img src="{{ asset('img/flash.svg') }}" alt="Flash" class="camera-icon">
                    </button>
                </div>
            </div>

            <div class="photo-notice">
                <span class="warning-icon">!</span> Foto Anda akan diproses secara aman untuk keperluan pameran saja.
            </div>
        </div>

        <div class="step-actions">
            <a href="/guest-form" class="btn-secondary">Kembali</a>
            <button type="button" id="nextBtn" class="btn-continue" onclick="submitPhoto()">Selanjutnya</button>
        </div>

        <form id="photoForm" method="POST" action="/guest-photo" enctype="multipart/form-data" style="display:none">
            @csrf
            <input type="file" id="fotoInput" name="foto" accept="image/*">
        </form>
    </div>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoEl = document.getElementById('cameraVideo');
            const canvasEl = document.getElementById('snapshotCanvas');
            const retryBtn = document.getElementById('retryBtn');
            const shutterBtn = document.getElementById('shutterBtn');
            const flashBtn = document.getElementById('flashBtn');
            const cameraFallback = document.getElementById('cameraFallback');
            const cameraPreview = document.getElementById('cameraPreview');
            const cameraControls = document.getElementById('cameraControls');
            let stream = null;
            let flashEnabled = false;

            function startCamera() {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    cameraFallback.style.display = 'flex';
                    return;
                }

                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false })
                    .then(mediaStream => {
                        stream = mediaStream;
                        videoEl.srcObject = mediaStream;
                        videoEl.play();
                        cameraFallback.style.display = 'none';
                    })
                    .catch(() => {
                        cameraFallback.style.display = 'flex';
                    });
            }

            function takePhoto() {
                if (!stream || !videoEl.videoWidth) {
                    return;
                }

                canvasEl.width = videoEl.videoWidth;
                canvasEl.height = videoEl.videoHeight;
                const context = canvasEl.getContext('2d');
                context.drawImage(videoEl, 0, 0, canvasEl.width, canvasEl.height);

                const imageData = canvasEl.toDataURL('image/png');
                const capturedImage = document.createElement('img');
                capturedImage.src = imageData;
                capturedImage.className = 'captured-photo';

                videoEl.style.display = 'none';
                const existingImage = cameraPreview.querySelector('.captured-photo');
                if (existingImage) {
                    existingImage.remove();
                }
                cameraPreview.appendChild(capturedImage);

                // Keep controls visible after photo is taken
            }

            function resetPhoto() {
                const existingImage = cameraPreview.querySelector('.captured-photo');
                if (existingImage) {
                    existingImage.remove();
                }
                videoEl.style.display = 'block';
                // Show controls again
                cameraControls.classList.remove('hidden');
            }

            retryBtn.addEventListener('click', () => {
                resetPhoto();
            });

            shutterBtn.addEventListener('click', () => {
                takePhoto();
            });

            flashBtn.addEventListener('click', () => {
                flashEnabled = !flashEnabled;
                flashBtn.style.backgroundColor = flashEnabled ? '#FFB800' : 'transparent';
            });

            startCamera();

            // Submit photo function
            window.submitPhoto = function() {
                const capturedImg = cameraPreview.querySelector('.captured-photo');
                if (!capturedImg) {
                    alert('Silakan ambil foto terlebih dahulu');
                    return;
                }
                // Convert base64 to blob then submit
                fetch(capturedImg.src)
                    .then(r => r.blob())
                    .then(blob => {
                        const file = new File([blob], 'foto.png', { type: 'image/png' });
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        document.getElementById('fotoInput').files = dt.files;
                        document.getElementById('photoForm').submit();
                    });
            };
        });
    </script>

</body>
</html>
