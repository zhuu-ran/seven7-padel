<?php
session_start();
include 'config/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = $search ? "WHERE status='aktif' AND (nama LIKE '%$search%' OR lokasi LIKE '%$search%')" : "WHERE status='aktif'";
$lapangan_list = mysqli_query($koneksi, "SELECT * FROM lapangan $where ORDER BY nama");
$total = mysqli_num_rows($lapangan_list);
$lapangan_list = mysqli_query($koneksi, "SELECT * FROM lapangan $where ORDER BY nama");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking - SEVEN7 PADEL</title>
    <link rel="icon" href="img/logo.png" type="img/png">
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
            <a href="index.php" class="venue">Home</a>
            <a href="venue.php" class="play" style="color:#4b4b4d; font-weight:700">Venue Booking</a>
            <a href="openplay.php" class="play">Open Play</a>
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

    <div class="venue-page">
        <div class="venue-search-bar">
            <form method="GET" class="search-form-venue">
                <div class="search-input">
                    <i class="fa fa-search"></i>
                    <input type="text" name="search" placeholder="Cari nama venue..." value="<?= $search ?>">
                </div>
                <button type="submit" class="btn-cari">Cari Venue</button>
                <?php if ($search): ?>
                    <a href="venue.php" class="btn-reset">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="venue-info-bar">
            <p>Menampilkan <strong><?= $total ?> venue</strong> tersedia</p>
        </div>

        <div class="venue-grid">
            <?php while ($lapangan = mysqli_fetch_assoc($lapangan_list)): 
                $min_harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MIN(harga) as min FROM slot_waktu WHERE lapangan_id=".$lapangan['id']));
            ?>
            <a href="detail.php?id=<?= $lapangan['id'] ?>" class="venue-card">
                <div class="venue-card-img">
                    <?php if ($lapangan['foto']): ?>
                        <img src="img/<?= $lapangan['foto'] ?>" alt="<?= $lapangan['nama'] ?>">
                    <?php else: ?>
                        <div class="venue-card-noimg"><i class="fa fa-image"></i></div>
                    <?php endif; ?>
                </div>
                
                <div class="venue-card-info">
                    <p class="venue-card-type">Venue</p>
                    <h3><?= $lapangan['nama'] ?></h3>
                    <p class="venue-card-lokasi">📍 <?= $lapangan['lokasi'] ?></p>
                    <p class="venue-card-tipe"><i class="fa fa-table-tennis-paddle-ball"></i> Padel</p>
                    <p class="venue-card-harga">
                        Mulai <strong>Rp <?= $min_harga['min'] ? number_format($min_harga['min'],0,',','.') : '0' ?></strong>/sesi
                    </p>
                </div>
            </a>
            <?php endwhile; ?>
        </div>
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
