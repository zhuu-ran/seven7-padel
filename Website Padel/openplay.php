<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Play - SEVEN7 PADEL</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <div class="logo"><img src="img/logo1.jpeg" alt="logo"></div>
            <a href="venue.php" class="venue">Venue Booking</a>
            <a href="openplay.php" class="play" style="color:#4b4b4d; font-weight:700">Open Play</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['id'])): ?>
                <span>Halo, <?= $_SESSION['nama'] ?>!</span>
                <a href="auth/logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="#" class="btn-sign" id="btnSignIn">Sign In</a>
                <a href="#" class="btn-regist" id="btnRegist">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="openplay-page">
        <div class="openplay-header">
            <h1>Open Play</h1>
            <p>Temukan event padel seru di sekitarmu dan bergabunglah bersama komunitas!</p>
        </div>

        <div class="event-grid">

            <div class="event-card">
                <img src="img/event1.jpeg" alt="Event 1">
                <div class="event-info">
                    <span class="event-tag">Padel</span>
                    <h3>Fun Game Padel Bandung</h3>
                    <p><i class="fa fa-calendar"></i> Sabtu, 5 Jul 2025 · 08:00 - 10:00</p>
                    <p><i class="fa fa-location-dot"></i> Padelwood, Bandung Utara</p>
                </div>
            </div>

            <div class="event-card">
                <img src="img/event2.jpeg" alt="Event 2">
                <div class="event-info">
                    <span class="event-tag">Padel</span>
                    <h3>Mabar Padel Weekend</h3>
                    <p><i class="fa fa-calendar"></i> Minggu, 6 Jul 2025 · 10:00 - 12:00</p>
                    <p><i class="fa fa-location-dot"></i> La Familia, Sukajadi</p>
                </div>
            </div>

            <div class="event-card">
                <img src="img/event3.jpeg" alt="Event 3">
                <div class="event-info">
                    <span class="event-tag">Padel</span>
                    <h3>Padel Community Open</h3>
                    <p><i class="fa fa-calendar"></i> Senin, 7 Jul 2025 · 15:00 - 17:00</p>
                    <p><i class="fa fa-location-dot"></i> Americano Padel, Sukasari</p>
                </div>
            </div>

            <div class="event-card">
                <img src="img/event4.jpeg" alt="Event 4">
                <div class="event-info">
                    <span class="event-tag">Padel</span>
                    <h3>Turnamen Mini Padel</h3>
                    <p><i class="fa fa-calendar"></i> Selasa, 8 Jul 2025 · 09:00 - 12:00</p>
                    <p><i class="fa fa-location-dot"></i> Gauri Padel, Pasteur</p>
                </div>
            </div>

            <div class="event-card">
                <img src="img/event5.jpeg" alt="Event 5">
                <div class="event-info">
                    <span class="event-tag">Padel</span>
                    <h3>Padel For Beginners</h3>
                    <p><i class="fa fa-calendar"></i> Rabu, 9 Jul 2025 · 07:00 - 09:00</p>
                    <p><i class="fa fa-location-dot"></i> Padela, Sukagalih</p>
                </div>
            </div>

            <div class="event-card">
                <img src="img/event6.jpeg" alt="Event 6">
                <div class="event-info">
                    <span class="event-tag">Padel</span>
                    <h3>Evening Padel Session</h3>
                    <p><i class="fa fa-calendar"></i> Kamis, 10 Jul 2025 · 18:00 - 20:00</p>
                    <p><i class="fa fa-location-dot"></i> Padelwood, Bandung Utara</p>
                </div>
            </div>

        </div>
    </div>

    <div class="banner-section">
        <div class="banner-text">
            <h2>Booking Lapangan Jadi Mudah & Aman</h2>
            <p>Temukan lapangan padel terbaik di Bandung dan mulai bermain sekarang!</p>
            <a href="venue.php" class="btn-cek">Cari Lapangan</a>
        </div>
        <img src="img/banner.jpeg" alt="Banner">
    </div>

    <footer class="footer">
        <div class="footer-wrapper">
            <div class="footer-col">
                <h3>SEVEN7 PADEL</h3>
                <p>Jl. Setramurni Raya No.33</p>
                <p>Bandung, Jawa Barat</p>
                <div class="footer-sosmed">
                    <a href="https://www.instagram.com/zhuo_rann/"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61588311869257"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.tiktok.com/@zhuozhuo164?is_from_webapp=1&sender_device=pc"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <a href="#">Tentang Kami</a>
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
            </div>
            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <a href="https://wa.me/6281320350419">Kontak</a>
                <a href="https://wa.me/6281320350419">WhatsApp</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Seven7 Padel. All Rights Reserved.</p>
        </div>
    </footer>

    <div class="modal-overlay" id="modalLogin">
        <div class="modal-box">
            <span class="modal-close" id="closeLogin">&times;</span>
            <h2>Sign In</h2>
            <form action="auth/login.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <div class="input-password">
                    <input type="password" name="password" placeholder="Password" id="passwordLogin" required>
                    <span class="toggle-password" onclick="togglePassword('passwordLogin', this)">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <button type="submit" class="btn-submit" id="btnLogin">Sign In</button>
            </form>
            <p>Belum punya akun? <a href="#" id="toRegister">Register</a></p>
        </div>
    </div>

    <div class="modal-overlay" id="modalRegister">
        <div class="modal-box">
            <span class="modal-close" id="closeRegister">&times;</span>
            <h2>Register</h2>
            <form action="auth/register.php" method="POST">
                <input type="text" name="nama" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <div class="input-password">
                    <input type="password" name="password" placeholder="Password" id="passwordRegister" required>
                    <span class="toggle-password" onclick="togglePassword('passwordRegister', this)">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <button type="submit" class="btn-submit">Register</button>
            </form>
            <p>Sudah punya akun? <a href="#" id="toLogin">Sign In</a></p>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalLogin = document.getElementById('modalLogin');
        const modalRegister = document.getElementById('modalRegister');
        const btnSign = document.getElementById('btnSignIn');
        const btnRegist = document.getElementById('btnRegist');
        if (btnSign) btnSign.addEventListener('click', (e) => { e.preventDefault(); modalLogin.classList.add('active'); });
        if (btnRegist) btnRegist.addEventListener('click', (e) => { e.preventDefault(); modalRegister.classList.add('active'); });
        document.getElementById('closeLogin').addEventListener('click', () => modalLogin.classList.remove('active'));
        document.getElementById('closeRegister').addEventListener('click', () => modalRegister.classList.remove('active'));
        document.getElementById('toRegister').addEventListener('click', (e) => { e.preventDefault(); modalLogin.classList.remove('active'); modalRegister.classList.add('active'); });
        document.getElementById('toLogin').addEventListener('click', (e) => { e.preventDefault(); modalRegister.classList.remove('active'); modalLogin.classList.add('active'); });
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });
        });
    });
    </script>
</body>
</html>
