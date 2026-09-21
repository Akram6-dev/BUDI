<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ambil Foto - BUDI Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/mrc-theme.css') }}">
    <style>
        .form-page-container {
            max-width: 620px;
            margin: 2.5rem auto 4rem;
            padding: 0 1.25rem;
        }

        .stepper-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .stepper-step {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stepper-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stepper-track {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .stepper-bar {
            height: 6px;
            border-radius: var(--radius-full);
            background-color: var(--border-main);
            transition: all 0.3s ease;
        }

        .stepper-bar.active {
            background-color: var(--accent);
        }

        /* Camera Box */
        .camera-wrapper {
            position: relative;
            width: 100%;
            height: 380px;
            border-radius: var(--radius-xl);
            overflow: hidden;
            background: #0f172a;
            border: 2px solid var(--border-main);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #cameraVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .captured-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .camera-fallback {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            color: #94a3b8;
            font-size: 0.875rem;
            padding: 2rem;
            text-align: center;
        }

        .camera-countdown {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.45);
            color: #ffffff;
            font-size: 5rem;
            font-weight: 800;
            z-index: 20;
            pointer-events: none;
        }

        .camera-flash-overlay {
            position: absolute;
            inset: 0;
            background: #ffffff;
            z-index: 25;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .camera-flash-overlay.active {
            opacity: 1;
        }

        /* Camera Controls Bar */
        .camera-controls-bar {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            z-index: 15;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(8px);
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius-full);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-shutter-outer {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 3px solid #ffffff;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-shutter-inner {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #ffffff;
            transition: transform 0.15s ease;
        }

        .btn-shutter-outer:hover .btn-shutter-inner {
            transform: scale(0.92);
            background: #e2e8f0;
        }

        .btn-shutter-outer:active .btn-shutter-inner {
            transform: scale(0.85);
            background: var(--accent);
        }

        .btn-cam-control {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-cam-control:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .step-nav-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.75rem;
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <main class="form-page-container">
        <!-- Stepper -->
        <div class="stepper-header">
            <span class="stepper-step">Langkah 2 dari 3</span>
            <span class="stepper-label">Foto Pengunjung</span>
        </div>
        <div class="stepper-track">
            <div class="stepper-bar active"></div>
            <div class="stepper-bar active"></div>
            <div class="stepper-bar"></div>
        </div>

        <!-- Camera Card -->
        <div class="mrc-card" style="padding: 2rem;">
            <div style="margin-bottom: 1.5rem;">
                <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">Ambil Foto Anda</h1>
                <p style="font-size: 0.875rem; color: var(--text-muted);">Posisikan wajah Anda di tengah layar, lalu tekan tombol jepret.</p>
            </div>

            <div class="camera-wrapper" id="cameraWrapper">
                <video id="cameraVideo" autoplay playsinline muted></video>
                <canvas id="snapshotCanvas" style="display: none;"></canvas>
                
                <div class="camera-fallback" id="cameraFallback">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                        <circle cx="12" cy="13" r="3"/>
                        <line x1="2" y1="2" x2="22" y2="22"/>
                    </svg>
                    <span>Kamera tidak terdeteksi atau izin akses dinonaktifkan. Pastikan izin kamera telah diaktifkan di browser.</span>
                </div>

                <div class="camera-countdown" id="cameraCountdown">3</div>
                <div class="camera-flash-overlay" id="cameraFlashOverlay"></div>

                <!-- Camera Overlay Controls -->
                <div class="camera-controls-bar" id="cameraControls">
                    <button type="button" id="retryBtn" class="btn-cam-control" title="Ulangi Foto" style="display: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                        </svg>
                    </button>

                    <button type="button" id="shutterBtn" class="btn-shutter-outer" title="Jepret Foto">
                        <span class="btn-shutter-inner"></span>
                    </button>

                    <button type="button" id="flashBtn" class="btn-cam-control" title="Efek Flash">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="step-nav-actions">
                <a href="/guest-form" class="btn-mrc btn-mrc-outline" style="padding: 0.75rem 1.25rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    <span>Kembali</span>
                </a>

                <button type="button" id="nextBtn" class="btn-mrc btn-mrc-accent" onclick="goToSignature()" disabled style="opacity: 0.5; cursor: not-allowed; padding: 0.75rem 1.5rem;">
                    <span>Lanjutkan ke Tanda Tangan</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoEl = document.getElementById('cameraVideo');
            const canvasEl = document.getElementById('snapshotCanvas');
            const retryBtn = document.getElementById('retryBtn');
            const shutterBtn = document.getElementById('shutterBtn');
            const flashBtn = document.getElementById('flashBtn');
            const cameraFallback = document.getElementById('cameraFallback');
            const cameraWrapper = document.getElementById('cameraWrapper');
            const cameraControls = document.getElementById('cameraControls');
            const nextBtn = document.getElementById('nextBtn');
            let stream = null;
            let flashEnabled = true;

            function startCamera() {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    cameraFallback.style.display = 'flex';
                    videoEl.style.display = 'none';
                    return;
                }

                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }, audio: false })
                    .then(mediaStream => {
                        stream = mediaStream;
                        videoEl.srcObject = mediaStream;
                        videoEl.play();
                        cameraFallback.style.display = 'none';
                    })
                    .catch(() => {
                        cameraFallback.style.display = 'flex';
                        videoEl.style.display = 'none';
                    });
            }

            function takePhoto() {
                if (!stream || !videoEl.videoWidth) return;

                const maxWidth = 640;
                const scale = Math.min(maxWidth / videoEl.videoWidth, 1);
                canvasEl.width = Math.round(videoEl.videoWidth * scale);
                canvasEl.height = Math.round(videoEl.videoHeight * scale);
                const ctx = canvasEl.getContext('2d');
                ctx.drawImage(videoEl, 0, 0, canvasEl.width, canvasEl.height);

                const imageData = canvasEl.toDataURL('image/jpeg', 0.75);

                const capturedImage = document.createElement('img');
                capturedImage.src = imageData;
                capturedImage.className = 'captured-photo';

                videoEl.style.display = 'none';
                const existing = cameraWrapper.querySelector('.captured-photo');
                if (existing) existing.remove();
                cameraWrapper.appendChild(capturedImage);

                // Save to sessionStorage
                sessionStorage.setItem('capturedPhoto', imageData);

                // Update UI state
                retryBtn.style.display = 'inline-flex';
                shutterBtn.style.display = 'none';
                nextBtn.disabled = false;
                nextBtn.style.opacity = '1';
                nextBtn.style.cursor = 'pointer';
            }

            function resetPhoto() {
                const existing = cameraWrapper.querySelector('.captured-photo');
                if (existing) existing.remove();
                videoEl.style.display = 'block';
                sessionStorage.removeItem('capturedPhoto');

                retryBtn.style.display = 'none';
                shutterBtn.style.display = 'inline-flex';
                nextBtn.disabled = true;
                nextBtn.style.opacity = '0.5';
                nextBtn.style.cursor = 'not-allowed';
            }

            retryBtn.addEventListener('click', resetPhoto);

            let countdownInterval = null;
            shutterBtn.addEventListener('click', () => {
                if (videoEl.style.display === 'none' || cameraFallback.style.display === 'flex') return;
                if (countdownInterval) return;

                shutterBtn.disabled = true;
                const countdownEl = document.getElementById('cameraCountdown');
                countdownEl.style.display = 'flex';

                let timeLeft = 3;
                countdownEl.textContent = timeLeft;

                countdownInterval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft > 0) {
                        countdownEl.textContent = timeLeft;
                    } else {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                        countdownEl.style.display = 'none';

                        if (flashEnabled) {
                            const flashOverlay = document.getElementById('cameraFlashOverlay');
                            flashOverlay.classList.add('active');
                            setTimeout(() => {
                                flashOverlay.classList.remove('active');
                            }, 150);
                        }

                        takePhoto();
                        shutterBtn.disabled = false;
                    }
                }, 800);
            });

            flashBtn.addEventListener('click', () => {
                flashEnabled = !flashEnabled;
                flashBtn.style.color = flashEnabled ? '#facc15' : '#ffffff';
            });

            startCamera();

            // Restore from sessionStorage
            const savedPhoto = sessionStorage.getItem('capturedPhoto');
            if (savedPhoto) {
                const capturedImage = document.createElement('img');
                capturedImage.src = savedPhoto;
                capturedImage.className = 'captured-photo';
                videoEl.style.display = 'none';
                cameraWrapper.appendChild(capturedImage);
                retryBtn.style.display = 'inline-flex';
                shutterBtn.style.display = 'none';
                nextBtn.disabled = false;
                nextBtn.style.opacity = '1';
                nextBtn.style.cursor = 'pointer';
            }

            window.goToSignature = function() {
                const captured = sessionStorage.getItem('capturedPhoto');
                if (!captured) {
                    alert('Silakan ambil foto Anda terlebih dahulu.');
                    return;
                }
                if (stream) stream.getTracks().forEach(t => t.stop());
                window.location.href = '/guest-signature';
            };
        });
    </script>

</body>
</html>
