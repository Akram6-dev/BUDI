<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Data Tamu - Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guest-form.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar-form">
        <div class="nav-left">
            <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo Nesasa" class="nav-logo">
            <span class="nav-title">PAMERAN TKI</span>
        </div>
        <a href="/login" class="btn-login">Login Admin</a>
    </nav>

    <!-- Main Content -->
    <div class="main-content-form">
        <!-- Step Indicator -->
        <div class="step-container">
            <h2 class="step-title">Step 1 of 3</h2>
            
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
            <h3 class="form-card-title">Isi Identitas Anda</h3>

            <form id="guestForm" method="POST" action="/submit-guest-data">
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
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-form">
        © 2024 PAMERAN TKI - SMKN 1 SUBANG
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusCards = document.querySelectorAll('.status-card');
            const statusInput = document.getElementById('statusInput');
            const classGroup = document.getElementById('classGroup');
            const classSelect = document.getElementById('classSelect');

            statusCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all cards
                    statusCards.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked card
                    this.classList.add('active');
                    
                    // Set the status value
                    const status = this.getAttribute('data-status');
                    statusInput.value = status;

                    // Show class selection if Murid is selected
                    if (status === 'murid') {
                        classGroup.style.display = 'block';
                        classSelect.required = true;
                    } else {
                        classGroup.style.display = 'none';
                        classSelect.required = false;
                        classSelect.value = '';
                    }
                });
            });

            // Form submission
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

                // If validation passes, submit the form
                // this.submit();
                console.log({
                    full_name: document.getElementById('fullName').value,
                    status: statusInput.value,
                    class: classSelect.value
                });
            });
        });
    </script>

</body>
</html>
