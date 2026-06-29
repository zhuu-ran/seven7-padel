<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

if ($id == 0) { header('Location: venue.php'); exit(); }

$result = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id=$id AND status='aktif'");
$lapangan = mysqli_fetch_assoc($result);
if (!$lapangan) { header('Location: venue.php'); exit(); }

$min_harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MIN(harga) as min FROM slot_waktu WHERE lapangan_id=$id"));
$jam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MIN(jam_mulai) as buka, MAX(jam_selesai) as tutup FROM slot_waktu WHERE lapangan_id=$id"));

$foto_list = mysqli_query($koneksi, "SELECT foto FROM foto_lapangan WHERE lapangan_id=$id");
$foto_extra = [];
while ($f = mysqli_fetch_assoc($foto_list)) $foto_extra[] = $f['foto'];
$total_foto = ($lapangan['foto'] ? 1 : 0) + count($foto_extra);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lapangan['nama'] ?> - SEVEN7 PADEL</title>
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
            <a href="openplay.php" class="play">Open Play</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['id'])): ?>
                <span>Halo, <?= $_SESSION['nama'] ?>!</span>
                <a href="auth/logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="#" class="btn-sign">Sign In</a>
                <a href="#" class="btn-regist">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="content-1">
        <div class="cont-venue">
            <div class="slider-wrapper">
                <button class="prev">&#8249;</button>
                <div class="foto-slider">
                    <?php if ($lapangan['foto']): ?>
                        <img src="img/<?= $lapangan['foto'] ?>" alt="<?= $lapangan['nama'] ?>">
                    <?php else: ?>
                        <div style="min-width:100%;height:450px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;font-size:60px;color:#ccc">
                            <i class="fa fa-image"></i>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($foto_extra as $foto): ?>
                        <img src="img/<?= $foto ?>" alt="<?= $lapangan['nama'] ?>">
                    <?php endforeach; ?>
                </div>
                <button class="next">&#8250;</button>
                <div class="dots">
                    <?php for ($i = 0; $i < $total_foto; $i++): ?>
                        <span class="dot <?= $i==0?'active':'' ?>"></span>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="venue-info">
                <h1><?= $lapangan['nama'] ?></h1>
                <p>🕐 <?= substr($jam['buka'],0,5) ?> - <?= substr($jam['tutup'],0,5) ?> Everyday</p>
                <p>📍 <?= $lapangan['lokasi'] ?></p>
            </div>
        </div>
    </div>

    <div class="content-2">
        <div class="desc-wrapper">
            <div class="desc-left">
                <h2><?= $lapangan['nama'] ?></h2>
                <p class="desc-sub">Bandung, Jawa Barat</p>
                <div class="desc-section">
                    <h4>Deskripsi</h4>
                    <p>Lapangan padel berkualitas premium dengan permukaan synthetic grass terbaik.</p>
                    <p><?= substr($jam['buka'],0,5) ?> - <?= substr($jam['tutup'],0,5) ?> Everyday</p>
                    <p><?= $lapangan['lokasi'] ?></p>
                </div>
                <div class="desc-section">
                    <h4>Aturan Venue</h4>
                    <ol>
                        <li>Book lapangan terlebih dahulu dan tepati jadwal</li>
                        <li>Gunakan pakaian olahraga dan sepatu non-marking</li>
                        <li>Dilarang membawa alkohol atau zat terlarang</li>
                        <li>Jaga sikap sportif dan saling menghormati</li>
                        <li>Pemain bertanggung jawab atas cedera masing-masing</li>
                    </ol>
                </div>
                <div class="desc-section">
                    <h4>Fasilitas</h4>
                    <div class="fasilitas-grid">
                        <span><i class="fa fa-car"></i> Parkir Mobil</span>
                        <span><i class="fa fa-motorcycle"></i> Parkir Motor</span>
                        <span><i class="fa fa-restroom"></i> Toilet</span>
                        <span><i class="fa fa-shower"></i> Shower</span>
                        <span><i class="fa fa-person-booth"></i> Ruang Ganti</span>
                        <span><i class="fa fa-bottle-water"></i> Jual Minuman</span>
                    </div>
                </div>
            </div>
            <div class="desc-right">
                <div class="price-card">
                    <p class="price-label">Mulai dari</p>
                    <h3>Rp <?= $min_harga['min'] ? number_format($min_harga['min'],0,',','.') : '0' ?> <span>Per Sesi</span></h3>
                    <?php if (isset($_SESSION['id'])): ?>
                        <a href="booking_form.php?lapangan_id=<?= $id ?>&tanggal=<?= $tanggal ?>" class="btn-cek">Pesan Sekarang</a>
                    <?php else: ?>
                        <a href="#" class="btn-cek" onclick="document.getElementById('modalLogin').classList.add('active'); return false;">Pesan Sekarang</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="content-3" id="pilih-jadwal">
        <div class="lapangan-wrapper">
            <h2>Pilih Jadwal</h2>
            <div class="tanggal-wrapper">
                <?php
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days"));
                    $hari = date('D', strtotime($date));
                    $tgl = date('d M', strtotime($date));
                    $active = $date == $tanggal ? 'active' : '';
                    echo "<a href='detail.php?id=$id&tanggal=$date#pilih-jadwal' class='tanggal-item $active'>
                            <span class='hari'>$hari</span>
                            <span class='tgl'>$tgl</span>
                          </a>";
                }
                ?>
            </div>

            <div class="slot-list" style="margin-top:16px">
                <?php
                $slots = mysqli_query($koneksi, "SELECT * FROM slot_waktu WHERE lapangan_id=$id ORDER BY jam_mulai");
                while ($slot = mysqli_fetch_assoc($slots)):
                    $cek = mysqli_query($koneksi, "SELECT * FROM booking WHERE slot_id=".$slot['id']." AND tanggal='$tanggal' AND status!='cancelled'");
                    $booked = mysqli_num_rows($cek) > 0;
                    $durasi = (strtotime($slot['jam_selesai']) - strtotime($slot['jam_mulai'])) / 60;
                ?>
                <div class="slot-item <?= $booked ? 'booked' : 'available' ?>">
                    <span class="slot-durasi"><?= $durasi ?> Menit</span>
                    <span class="slot-jam"><?= substr($slot['jam_mulai'],0,5) ?> - <?= substr($slot['jam_selesai'],0,5) ?></span>
                    <?php if ($booked): ?>
                        <span class="slot-status-booked">Booked</span>
                    <?php else: ?>
                        <span class="slot-harga">Rp <?= number_format($slot['harga'],0,',','.') ?></span>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
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
                <input type="hidden" name="redirect" value="detail.php?id=<?= $id ?>&tanggal=<?= $tanggal ?>">
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
    
</body>
</html>