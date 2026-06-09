                                                                                                                                                                                                                                                                                                                                                                 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ambil Foto - Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guest-form.css') }}">
    <style>
        .camera-countdown {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.4);
            color: #FFB800;
            font-size: 6rem;
            font-weight: 800;
            z-index: 10;
            font-family: 'Inter', sans-serif;
            text-shadow: 0 0 20px rgba(255, 184, 0, 0.6);
            pointer-events: none;
            transition: all 0.2s ease-in-out;
        }
        
        .camera-flash-overlay {
            position: absolute;
            inset: 0;
            background: #ffffff;
            z-index: 11;
            opacity: 0;
            pointer-events: none;
        }
        .camera-flash-overlay.active {
            opacity: 1;
        }
    </style>
</head>
<body class="guest-form-body">

    @include('layouts.ai-bg')
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
                <div class="camera-countdown" id="cameraCountdown" style="display: none;"></div>
                <div class="camera-flash-overlay" id="cameraFlashOverlay"></div>

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
            <button type="button" id="nextBtn" class="btn-continue" onclick="goToSignature()" disabled style="opacity:0.5;cursor:not-allowed;">Selanjutnya</button>
        </div>
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

                // Simpan ke sessionStorage
                sessionStorage.setItem('capturedPhoto', imageData);

                // Aktifkan tombol selanjutnya
                const nextBtn = document.getElementById('nextBtn');
                nextBtn.disabled = false;
                nextBtn.style.opacity = '1';
                nextBtn.style.cursor = 'pointer';
            }

            function resetPhoto() {
                const existingImage = cameraPreview.querySelector('.captured-photo');
                if (existingImage) {
                    existingImage.remove();
                }
                videoEl.style.display = 'block';
                cameraControls.classList.remove('hidden');
                sessionStorage.removeItem('capturedPhoto');

                // Disable tombol selanjutnya lagi
                const nextBtn = document.getElementById('nextBtn');
                nextBtn.disabled = true;
                nextBtn.style.opacity = '0.5';
                nextBtn.style.cursor = 'not-allowed';
            }

            retryBtn.addEventListener('click', () => {
                resetPhoto();
            });

            let countdownInterval = null;
            shutterBtn.addEventListener('click', () => {
                if (videoEl.style.display === 'none' || cameraFallback.style.display === 'flex') {
                    return;
                }

                if (countdownInterval) return;

                shutterBtn.disabled = true;
                shutterBtn.style.opacity = '0.5';
                retryBtn.disabled = true;
                retryBtn.style.opacity = '0.5';

                const countdownEl = document.getElementById('cameraCountdown');
                countdownEl.style.display = 'flex';
                
                let timeLeft = 2;
                
                function updateCountdown() {
                    countdownEl.textContent = timeLeft;
                    countdownEl.style.transform = 'scale(2)';
                    countdownEl.style.opacity = '0';
                    countdownEl.style.transition = 'none';
                    countdownEl.offsetHeight; // Force reflow
                    countdownEl.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    countdownEl.style.transform = 'scale(1)';
                    countdownEl.style.opacity = '1';
                }

                updateCountdown();

                countdownInterval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft > 0) {
                        updateCountdown();
                    } else {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                        countdownEl.style.display = 'none';

                        const flashOverlay = document.getElementById('cameraFlashOverlay');
                        flashOverlay.style.transition = 'none';
                        flashOverlay.classList.add('active');
                        
                        takePhoto();
                        
                        setTimeout(() => {
                            flashOverlay.style.transition = 'opacity 0.4s ease-out';
                            flashOverlay.classList.remove('active');
                        }, 50);

                        shutterBtn.disabled = false;
                        shutterBtn.style.opacity = '1';
                        retryBtn.disabled = false;
                        retryBtn.style.opacity = '1';
                    }
                }, 1000);
            });

            flashBtn.addEventListener('click', () => {
                flashEnabled = !flashEnabled;
                flashBtn.style.backgroundColor = flashEnabled ? '#FFB800' : 'transparent';
            });

            startCamera();

            // Restore foto dari sessionStorage
            const savedPhoto = sessionStorage.getItem('capturedPhoto');
            if (savedPhoto) {
                const capturedImage = document.createElement('img');
                capturedImage.src = savedPhoto;
                capturedImage.className = 'captured-photo';
                videoEl.style.display = 'none';
                cameraPreview.appendChild(capturedImage);
                const nextBtn = document.getElementById('nextBtn');
                nextBtn.disabled = false;
                nextBtn.style.opacity = '1';
                nextBtn.style.cursor = 'pointer';
            }

            // Navigate to signature page (tidak submit ke server)
            window.goToSignature = function() {
                const capturedImg = cameraPreview.querySelector('.captured-photo');
                if (!capturedImg) {
                    alert('Silakan ambil foto terlebih dahulu');
                    return;
                }
                cancelAnimationFrame(window._aiBgRaf);
                if (stream) stream.getTracks().forEach(t => t.stop());
                window.location.href = '/guest-signature';
            };
        });
    </script>

</body>
</html>
