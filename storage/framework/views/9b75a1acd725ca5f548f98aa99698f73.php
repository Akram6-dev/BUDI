<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanda Tangan - Pameran TKI</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/guest-form.css')); ?>">
</head>
<body class="guest-form-body">

    <?php echo $__env->make('layouts.ai-bg', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content-form">
        <div class="step-container">
            <h2 class="step-title">Step 3 of 3</h2>

            <div class="progress-wrapper">
                <div class="progress-bar-container">
                    <div class="progress-bar-segment active"></div>
                    <div class="progress-bar-segment active"></div>
                    <div class="progress-bar-segment active"></div>
                </div>
            </div>
        </div>

        <div class="form-card signature-card">
            <h1 class="form-card-title">Tanda Tangan (Opsional)</h1>

            <div class="signature-canvas-wrapper" id="signatureCanvasWrapper">
                <div class="signature-instruction" id="signatureInstruction">Tanda tangan di sini</div>
                <canvas id="signatureCanvas" class="signature-canvas"></canvas>
            </div>

            <button type="button" id="clearSignatureBtn" class="clear-signature-btn" title="Bersihkan">
                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6h14M8 6V4c0-1.1.9-2 2-2h2c1.1 0 2 .9 2 2v2m-9 0h10v11c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V6zm3 4v6m4-6v6" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Bersihkan</span>
            </button>

            <div class="photo-notice">
                <span class="warning-icon">!</span> Data anda akan diproses secara aman untuk keperluan pameran saja.
            </div>
        </div>

        <div class="step-actions">
            <a href="/guest-photo" class="btn-secondary">Kembali</a>
            <button type="button" id="skipBtn" class="btn-continue">Skip</button>
            <button type="button" id="submitBtn" class="btn-submit" style="display: none;">Submit</button>
        </div>

        <form id="signatureForm" method="POST" action="/submit-guest-data" style="display:none">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="fotoBase64" name="foto_base64">
            <input type="hidden" id="ttdBase64" name="tanda_tangan_base64">
        </form>
    </div>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            const clearBtn = document.getElementById('clearSignatureBtn');
            const skipBtn = document.getElementById('skipBtn');
            const submitBtn = document.getElementById('submitBtn');
            const signatureWrapper = document.getElementById('signatureCanvasWrapper');
            const signatureInstruction = document.getElementById('signatureInstruction');
            
            let isDrawing = false;
            let hasSignature = false;

            // Set canvas size
            function resizeCanvas() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
                ctx.strokeStyle = '#514532';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
            }

            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Restore tanda tangan dari sessionStorage
            const savedTTD = sessionStorage.getItem('savedSignature');
            if (savedTTD) {
                const img = new Image();
                img.onload = function() {
                    ctx.drawImage(img, 0, 0);
                    hasSignature = true;
                    updateButtons();
                    toggleInstruction();
                };
                img.src = savedTTD;
            }

            // Mouse events
            canvas.addEventListener('mousedown', (e) => {
                isDrawing = true;
                const rect = canvas.getBoundingClientRect();
                ctx.beginPath();
                ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
                hasSignature = true;
                updateButtons();
                toggleInstruction();
            });

            canvas.addEventListener('mousemove', (e) => {
                if (!isDrawing) return;
                const rect = canvas.getBoundingClientRect();
                ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
                ctx.stroke();
                hasSignature = true;
                updateButtons();
                toggleInstruction();
            });

            canvas.addEventListener('mouseup', () => {
                isDrawing = false;
                sessionStorage.setItem('savedSignature', canvas.toDataURL('image/png'));
            });

            canvas.addEventListener('mouseleave', () => {
                isDrawing = false;
            });

            // Touch events for mobile
            canvas.addEventListener('touchstart', (e) => {
                e.preventDefault();
                isDrawing = true;
                const rect = canvas.getBoundingClientRect();
                const touch = e.touches[0];
                ctx.beginPath();
                ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
                hasSignature = true;
                updateButtons();
                toggleInstruction();
            });

            canvas.addEventListener('touchmove', (e) => {
                e.preventDefault();
                if (!isDrawing) return;
                const rect = canvas.getBoundingClientRect();
                const touch = e.touches[0];
                ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
                ctx.stroke();
                hasSignature = true;
                updateButtons();
                toggleInstruction();
            });

            canvas.addEventListener('touchend', (e) => {
                e.preventDefault();
                isDrawing = false;
                sessionStorage.setItem('savedSignature', canvas.toDataURL('image/png'));
            });

            // Clear button
            clearBtn.addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                hasSignature = false;
                sessionStorage.removeItem('savedSignature');
                updateButtons();
                toggleInstruction();
            });

            // Update button visibility
            function updateButtons() {
                if (hasSignature) {
                    skipBtn.style.display = 'none';
                    submitBtn.style.display = 'inline-flex';
                } else {
                    skipBtn.style.display = 'inline-flex';
                    submitBtn.style.display = 'none';
                }
            }

            function toggleInstruction() {
                if (hasSignature) {
                    signatureWrapper.classList.add('hide-instruction');
                } else {
                    signatureWrapper.classList.remove('hide-instruction');
                }
            }

            // Fungsi untuk submit data (foto + signature/atau kosong)
            function submitAllData(withSignature = false) {
                cancelAnimationFrame(window._aiBgRaf);
                const capturedPhoto = sessionStorage.getItem('capturedPhoto');
                const savedSignature = sessionStorage.getItem('savedSignature');

                if (!capturedPhoto) {
                    alert('Foto tidak ditemukan. Silakan kembali ke step 2.');
                    return;
                }

                // Set foto (wajib)
                document.getElementById('fotoBase64').value = capturedPhoto;

                // Set tanda tangan (optional)
                if (withSignature && savedSignature) {
                    document.getElementById('ttdBase64').value = savedSignature;
                } else {
                    document.getElementById('ttdBase64').value = '';
                }

                // Clear sessionStorage
                sessionStorage.removeItem('capturedPhoto');
                sessionStorage.removeItem('savedSignature');

                // Submit form
                document.getElementById('signatureForm').submit();
            }

            // Skip - submit tanpa tanda tangan (hanya foto)
            skipBtn.addEventListener('click', () => {
                submitAllData(false);
            });

            // Submit dengan tanda tangan
            submitBtn.addEventListener('click', () => {
                submitAllData(true);
            });
        });
    </script>

</body>
</html>
<?php /**PATH D:\PROJECT\LARAVEL\BUDI\resources\views/tamu/guest-signature.blade.php ENDPATH**/ ?>