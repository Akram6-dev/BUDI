<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Data Tamu - Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guest-form.css') }}">
</head>
<body class="guest-form-body">

    @include('layouts.ai-bg')
    @include('layouts.navbar')

    <!-- Main Content -->
    <div class="main-content-form">
        <!-- Step Indicator -->
        <div class="step-container">
            <h1 class="step-title">Step 1 of 3</h1>
            
            <!-- Progress Bar -->
            <div class="progress-wrapper">
                <div class="progress-bar-container">
                    <div class="progress-bar-segment active"></div>
                    <div class="progress-bar-segment"></div>
                    <div class="progress-bar-segment"></div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <h1 class="form-card-title">Isi Identitas Anda</h1>

            <form id="guestForm" method="POST" action="/guest-form">
                @csrf

                <!-- Full Name Input -->
                <div class="form-group">
                    <label for="fullName" class="form-label">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="fullName" 
                        name="full_name" 
                        class="form-input" 
                        placeholder="Masukkan nama lengkap Anda"
                        value="{{ session('tamu.nama') }}"
                        required
                    >
                </div>

                <!-- Class Selection (Hidden by default, shown when Murid is selected) -->
                <div class="form-group" id="classGroup" style="display: none;">
                    <label for="classSelect" class="form-label">Pilih Kelas</label>
                    <input 
                        type="text" 
                        id="classSelect" 
                        name="class"
                        class="form-input"
                        placeholder="Pilih atau ketik kelas Anda"
                        list="classList"
                        value="{{ session('tamu.kelas') }}"
                    >
                    <datalist id="classList">
                        <option value="X PPLG 1"></option>
                        <option value="X PPLG 2"></option>
                        <option value="X TJKT 1"></option>
                        <option value="X TJKT 2"></option>
                        <option value="XI TKJ 2"></option>
                    </datalist>
                </div>

                <!-- Status Selection -->
                <div class="form-group">
                    <label class="form-label">Pilih Status</label>
                    
                    <div class="status-options">
                        <!-- Guru Option -->
                        <div class="status-card" data-status="guru">
                            <div class="status-card-image">
                                <img src="{{ asset('img/guru.svg') }}" alt="Guru">
                            </div>
                            <span class="status-card-label">Guru</span>
                        </div>

                        <!-- Murid Option -->
                        <div class="status-card" data-status="murid">
                            <div class="status-card-image">
                                <img src="{{ asset('img/murid.svg') }}" alt="Murid">
                            </div>
                            <span class="status-card-label">Murid</span>
                        </div>

                        <!-- Hidden Input for Status -->
                        <input type="hidden" id="statusInput" name="status" required>
                    </div>
                </div>

                <!-- Continue Button -->
                <div class="form-actions">
                    <button type="submit" class="btn-continue">Lanjutkan</button>
                </div>
            </form>

            <div class="photo-notice">
                <span class="warning-icon">!</span> Data anda akan diproses secara aman untuk keperluan pameran saja.
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusCards = document.querySelectorAll('.status-card');
            const statusInput = document.getElementById('statusInput');
            const classGroup = document.getElementById('classGroup');
            const classSelect = document.getElementById('classSelect');

            // Restore session state
            const savedStatus = '{{ session('tamu.status') }}';
            if (savedStatus) {
                const savedCard = document.querySelector(`[data-status="${savedStatus === 'siswa' ? 'murid' : savedStatus}"]`);
                if (savedCard) {
                    savedCard.classList.add('active');
                    statusInput.value = savedStatus === 'siswa' ? 'murid' : savedStatus;
                    if (savedStatus === 'siswa') {
                        classGroup.style.display = 'block';
                        classSelect.required = true;
                    }
                }
            }

            statusCards.forEach(card => {
                card.addEventListener('click', function() {
                    statusCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    const status = this.getAttribute('data-status');
                    statusInput.value = status;

                    if (status === 'murid') {
                        classGroup.style.display = 'block';
                        classSelect.required = true;
                    } else {
                        classGroup.style.display = 'none';
                        classSelect.required = false;
                        classSelect.value = ''; // auto clear kelas
                    }
                });
            });

            document.getElementById('guestForm').addEventListener('submit', function(e) {
                e.preventDefault();

                if (statusInput.value === '') {
                    alert('Silahkan pilih status terlebih dahulu');
                    return;
                }

                if (statusInput.value === 'murid' && !classSelect.value) {
                    alert('Silahkan pilih atau masukkan kelas');
                    return;
                }

                cancelAnimationFrame(window._aiBgRaf);
                this.submit();
            });
        });
    </script>

</body>
</html>
