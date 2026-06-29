<?php
session_start();
include 'config/db.php';
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
$lapangan_list = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE status='aktif'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEVEN7 PADEL</title>
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
                    <img src="img/Padelwood_1.jpeg" alt="Padelwood">
                    <img src="img/Padelwood_2.jpeg" alt="Padelwood">
                    <img src="img/Padelwood_3.jpeg" alt="Padelwood">
                </div>
                <button class="next">&#8250;</button>
                <div class="dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
            <div class="venue-info">
                <h1>Padelwood Bandung</h1>
                <p>🕐 08:00 - 12:00 Everyday</p>
                <p>📍 Jl. Setramurni Raya No.33, Sukarasa, Kec. Sukasari, Kota Bandung, Jawa Barat 40152</p>
            </div>
        </div>
    </div>

    <div class="content-2">
        <div class="desc-wrapper">
            <div class="desc-left">
                <h2>Padelwood Bandung</h2>
                <p class="desc-sub">4.9 · Bandung, Jawa Barat</p>
                <div class="desc-section">
                    <h4>Deskripsi</h4>
                    <p>4 Courts tersedia dengan fasilitas lengkap. Lapangan padel berkualitas premium dengan permukaan synthetic grass terbaik.</p>
                    <p>08:00 - 12:00 Everyday</p>
                    <p>Jl. Setramurni Raya No.33, Sukarasa, Bandung</p>
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
                    <h3>Rp 250.000 <span>Per Sesi</span></h3>
                    <a href="#pilih-lapangan" class="btn-cek">Cek Ketersediaan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-3" id="pilih-lapangan">
        <div class="lapangan-wrapper">
            <h2>Pilih Lapangan</h2>
            <div class="tanggal-wrapper">
                <?php
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days"));
                    $hari = date('D', strtotime($date));
                    $tgl = date('d M', strtotime($date));
                    $active = $date == $tanggal ? 'active' : '';
                    echo "<a href='?tanggal=$date#pilih-lapangan' class='tanggal-item $active'>
                            <span class='hari'>$hari</span>
                            <span class='tgl'>$tgl</span>
                          </a>";
                }
                ?>
            </div>

            <?php while ($lapangan = mysqli_fetch_assoc($lapangan_list)): ?>
            <div class="lapangan-card">
                <div class="lapangan-kiri">
                    <?php if ($lapangan['foto']): ?>
                        <img src="img/<?= $lapangan['foto'] ?>" alt="<?= $lapangan['nama'] ?>">
                    <?php else: ?>
                        <div class="no-foto"><i class="fa fa-image"></i></div>
                    <?php endif; ?>
                </div>
                <div class="lapangan-kanan">
                    <h3><?= $lapangan['nama'] ?></h3>
                        <p class="lapangan-lokasi">📍    <?= $lapangan['lokasi'] ?></p>
                        <p class="lapangan-tipe"><i class="fa fa-table-tennis-paddle-ball"></i> Padel</p>
                        <p class="lapangan-tipe"><i class="fa fa-house"></i> Indoor</p>
                        <p class="lapangan-tipe"><i class="fa fa-leaf"></i> Rumput Sintetis</p>
                    <?php
                    $total_slot = mysqli_num_rows(mysqli_query($koneksi, "SELECT s.id FROM slot_waktu s LEFT JOIN booking b ON s.id = b.slot_id AND b.tanggal='$tanggal' AND b.status!='cancelled' WHERE s.lapangan_id=".$lapangan['id']." AND b.id IS NULL"));
                    ?>
                    <div class="jadwal-badge" onclick="toggleSlot(<?= $lapangan['id'] ?>)" style="cursor:pointer">
                        <?= $total_slot ?> Jadwal Tersedia <i class="fa fa-chevron-down" style="font-size:10px"></i>
                    </div>
                    <div class="slot-list" id="slot-<?= $lapangan['id'] ?>" style="display:none; margin-top:12px">
                        <?php
                        $slots = mysqli_query($koneksi, "SELECT * FROM slot_waktu WHERE lapangan_id=".$lapangan['id']." ORDER BY jam_mulai");
                        while ($slot = mysqli_fetch_assoc($slots)):
                            $cek = mysqli_query($koneksi, "SELECT * FROM booking WHERE slot_id=".$slot['id']." AND tanggal='$tanggal' AND status!='cancelled'");
                            $booked = mysqli_num_rows($cek) > 0;
                        ?>
                        <div class="slot-item <?= $booked ? 'booked' : 'available' ?>">
                            <span class="slot-durasi">60 Menit</span>
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
    
</body>
</html>