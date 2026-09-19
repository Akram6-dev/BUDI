<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanda Tangan - BUDI Pameran TKI</title>
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
            background-color: var(--accent);
        }

        /* Signature Canvas Wrapper */
        .sig-canvas-wrapper {
            position: relative;
            width: 100%;
            height: 250px;
            border: 2px dashed var(--border-main);
            border-radius: var(--radius-xl);
            background: #ffffff;
            cursor: crosshair;
            overflow: hidden;
            touch-action: none;
            transition: border-color 0.2s ease;
        }

        .sig-canvas-wrapper:hover {
            border-color: #818cf8;
            box-shadow: 0 0 18px rgba(99, 102, 241, 0.35);
        }

        .sig-canvas {
            width: 100%;
            height: 100%;
            display: block;
        }

        .sig-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #cbd5e1;
            font-size: 1rem;
            font-weight: 500;
            pointer-events: none;
            user-select: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
        }

        .sig-watermark.hide {
            opacity: 0;
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
            <span class="stepper-step">Langkah 3 dari 3</span>
            <span class="stepper-label">Tanda Tangan Digital</span>
        </div>
        <div class="stepper-track">
            <div class="stepper-bar"></div>
            <div class="stepper-bar"></div>
            <div class="stepper-bar"></div>
        </div>

        <!-- Signature Card -->
        <div class="mrc-card" style="padding: 2.25rem;">
            <div style="margin-bottom: 1.5rem;">
                <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">Tanda Tangan Digital (Opsional)</h1>
                <p style="font-size: 0.875rem; color: var(--text-muted);">Gunakan jari atau kursor Anda untuk membubuhkan tanda tangan.</p>
            </div>

            <div class="sig-canvas-wrapper" id="sigWrapper">
                <div class="sig-watermark" id="sigWatermark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 19l7-7 3 3-7 7-3-3z"/>
                        <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                        <path d="M2 2l7.586 7.586"/>
                        <circle cx="11" cy="11" r="2"/>
                    </svg>
                    <span>Goreskan tanda tangan di sini</span>
                </div>
                <canvas id="signatureCanvas" class="sig-canvas"></canvas>
            </div>

            <!-- Canvas Tool -->
            <div style="display: flex; justify-content: flex-end; margin-top: 0.75rem;">
                <button type="button" id="clearBtn" class="btn-mrc btn-mrc-outline" style="padding: 0.4rem 0.875rem; font-size: 0.8125rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    </svg>
                    <span>Bersihkan</span>
                </button>
            </div>

            <!-- Nav Actions -->
            <div class="step-nav-actions">
                <a href="/guest-photo" class="btn-mrc btn-mrc-outline" style="padding: 0.75rem 1.25rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    <span>Kembali</span>
                </a>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="button" id="skipBtn" class="btn-mrc btn-mrc-secondary" style="padding: 0.75rem 1.25rem;">
                        <span>Lewati</span>
                    </button>
                    <button type="button" id="submitBtn" class="btn-mrc btn-mrc-accent" style="padding: 0.75rem 1.75rem;">
                        <span>Kirim Data Tamu</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <form id="signatureForm" method="POST" action="/submit-guest-data" style="display: none;">
                @csrf
                <input type="hidden" id="fotoBase64" name="foto_base64">
                <input type="hidden" id="ttdBase64" name="tanda_tangan_base64">
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            const clearBtn = document.getElementById('clearBtn');
            const skipBtn = document.getElementById('skipBtn');
            const submitBtn = document.getElementById('submitBtn');
            const watermark = document.getElementById('sigWatermark');

            let isDrawing = false;
            let hasSignature = false;

            function resizeCanvas() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
                prepareCanvas();
            }

            function prepareCanvas() {
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.strokeStyle = '#0f172a';
                ctx.lineWidth = 2.5;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
            }

            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Restore from sessionStorage if exists
            const savedTTD = sessionStorage.getItem('savedSignature');
            if (savedTTD) {
                const img = new Image();
                img.onload = function() {
                    prepareCanvas();
                    ctx.drawImage(img, 0, 0);
                    hasSignature = true;
                    watermark.classList.add('hide');
                };
                img.src = savedTTD;
            }

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            function startDraw(e) {
                isDrawing = true;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
                hasSignature = true;
                watermark.classList.add('hide');
            }

            function moveDraw(e) {
                if (!isDrawing) return;
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }

            function stopDraw() {
                if (isDrawing) {
                    isDrawing = false;
                    sessionStorage.setItem('savedSignature', canvas.toDataURL('image/png'));
                }
            }

            // Mouse events
            canvas.addEventListener('mousedown', startDraw);
            canvas.addEventListener('mousemove', moveDraw);
            window.addEventListener('mouseup', stopDraw);

            // Touch events
            canvas.addEventListener('touchstart', (e) => { e.preventDefault(); startDraw(e); }, { passive: false });
            canvas.addEventListener('touchmove', (e) => { e.preventDefault(); moveDraw(e); }, { passive: false });
            canvas.addEventListener('touchend', (e) => { e.preventDefault(); stopDraw(); }, { passive: false });

            clearBtn.addEventListener('click', () => {
                prepareCanvas();
                hasSignature = false;
                watermark.classList.remove('hide');
                sessionStorage.removeItem('savedSignature');
            });

            function submitData(includeSignature) {
                const capturedPhoto = sessionStorage.getItem('capturedPhoto');
                if (!capturedPhoto) {
                    alert('Foto kunjungan belum diambil. Silakan kembali ke langkah 2.');
                    window.location.href = '/guest-photo';
                    return;
                }

                document.getElementById('fotoBase64').value = capturedPhoto;
                if (includeSignature && hasSignature) {
                    document.getElementById('ttdBase64').value = canvas.toDataURL('image/png');
                } else {
                    document.getElementById('ttdBase64').value = '';
                }

                sessionStorage.removeItem('capturedPhoto');
                sessionStorage.removeItem('savedSignature');

                document.getElementById('signatureForm').submit();
            }

            skipBtn.addEventListener('click', () => submitData(false));
            submitBtn.addEventListener('click', () => submitData(true));
        });
    </script>

</body>
</html>
