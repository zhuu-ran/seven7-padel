<?php
ini_set('session.cookie_path', '/');
session_start();
include 'config/db.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

$lapangan_id = isset($_GET['lapangan_id']) ? (int)$_GET['lapangan_id'] : 0;
$slot_id = isset($_GET['slot_id']) ? (int)$_GET['slot_id'] : 0;
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

$lapangan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id=$lapangan_id"));

$slots = mysqli_query($koneksi, "
    SELECT s.* FROM slot_waktu s
    LEFT JOIN booking b ON s.id = b.slot_id AND b.tanggal='$tanggal' AND b.status != 'cancelled'
    WHERE s.lapangan_id=$lapangan_id AND b.id IS NULL
    ORDER BY s.jam_mulai
");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slot_id_post = (int)$_POST['slot_id'];
    $tanggal_post = $_POST['tanggal'];
    $nama_pemesan = mysqli_real_escape_string($koneksi, $_POST['nama_pemesan']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $user_id = $_SESSION['id'];

    $cek = mysqli_query($koneksi, "SELECT * FROM booking WHERE slot_id=$slot_id_post AND tanggal='$tanggal_post' AND status!='cancelled'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Slot ini sudah dibooking, pilih slot lain!";
    } else {
        $tgl_kode = date('Ymd');
        $count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM booking WHERE DATE(created_at) = CURDATE()"));
        $nomor = str_pad($count['total'] + 1, 4, '0', STR_PAD_LEFT);
        $kode = 'BK-' . $tgl_kode . '-' . $nomor;

        $insert = mysqli_query($koneksi, "INSERT INTO booking (kode_booking, user_id, slot_id, tanggal, status, nama_pemesan, no_hp) VALUES ('$kode', $user_id, $slot_id_post, '$tanggal_post', 'pending', '$nama_pemesan', '$no_hp')");
        
        if ($insert) {
            header("Location: booking_sukses.php?kode=$kode");
            exit();
        } else {
            $error = "Gagal menyimpan booking: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - SEVEN7 PADEL</title>
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
            <span>Halo, <?= $_SESSION['nama'] ?>!</span>
            <a href="auth/logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="booking-page">
        <div class="booking-wrapper">
            <div class="booking-left">
                <h2>Detail Booking</h2>

                <?php if (isset($error)): ?>
                    <div class="booking-error"><?= $error ?></div>
                <?php endif; ?>

                <div class="booking-info-card">
                    <?php if ($lapangan && $lapangan['foto']): ?>
                        <img src="img/<?= $lapangan['foto'] ?>" alt="<?= $lapangan['nama'] ?>">
                    <?php endif; ?>
                    <div class="booking-info-detail">
                        <h3><?= $lapangan ? $lapangan['nama'] : 'Lapangan' ?></h3>
                        <p><i class="fa fa-location-dot"></i> <?= $lapangan ? $lapangan['lokasi'] : '' ?></p>
                        <p><i class="fa fa-calendar"></i> <?= date('d F Y', strtotime($tanggal)) ?></p>
                    </div>
                </div>

                <form method="POST" class="booking-form">
                    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">

                    <div class="booking-field">
                        <label>Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" placeholder="Masukkan nama kamu" value="<?= isset($_POST['nama_pemesan']) ? htmlspecialchars($_POST['nama_pemesan']) : '' ?>" required style="padding:12px; border:1px solid #ddd; border-radius:8px; font-family:'Montserrat',sans-serif; font-size:13px; outline:none; width:100%; margin-top:6px">
                    </div>

                    <div class="booking-field">
                        <label>No HP / WhatsApp</label>
                        <input type="tel" name="no_hp" placeholder="Contoh: 08123456789" value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : '' ?>" required style="padding:12px; border:1px solid #ddd; border-radius:8px; font-family:'Montserrat',sans-serif; font-size:13px; outline:none; width:100%; margin-top:6px">
                    </div>
                    <div class="booking-field">
                    <label>Pilih Tanggal</label>
                    <div class="tanggal-wrapper" style="margin-bottom:0">
                        <?php
                        for ($i = 0; $i < 7; $i++) {
                            $date = date('Y-m-d', strtotime("+$i days"));
                            $hari = date('D', strtotime($date));
                            $tgl = date('d M', strtotime($date));
                            $active = $date == $tanggal ? 'active' : '';
                            echo "<a href='booking_form.php?lapangan_id=$lapangan_id&tanggal=$date' class='tanggal-item $active'>
                                    <span class='hari'>$hari</span>
                                    <span class='tgl'>$tgl</span>
                                </a>";
                        }
                        ?>
                    </div>
                </div>
                    <div class="booking-field">
                        <label>Pilih Slot Waktu</label>
                        <div class="slot-picker">
                            <?php
                            mysqli_data_seek($slots, 0);
                            while ($s = mysqli_fetch_assoc($slots)):
                                $durasi = (strtotime($s['jam_selesai']) - strtotime($s['jam_mulai'])) / 60;
                                $selected = $slot_id == $s['id'] ? 'selected' : '';
                            ?>
                            <label class="slot-pick-item <?= $selected ?>">
                                <input type="radio" name="slot_id" value="<?= $s['id'] ?>" <?= $selected ? 'checked' : '' ?> required>
                                <span class="slot-pick-durasi"><?= $durasi ?> Menit</span>
                                <span class="slot-pick-jam"><?= substr($s['jam_mulai'],0,5) ?> - <?= substr($s['jam_selesai'],0,5) ?></span>
                                <span class="slot-pick-harga">Rp <?= number_format($s['harga'],0,',','.') ?></span>
                            </label>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn-booking-submit">Konfirmasi Booking</button>
                </form>
            </div>

            <div class="booking-right">
                <div class="booking-summary">
                    <h3>Ringkasan</h3>
                    <div class="summary-row">
                        <span>Lapangan</span>
                        <span><?= $lapangan ? $lapangan['nama'] : '-' ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Tanggal</span>
                        <span><?= date('d M Y', strtotime($tanggal)) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Status</span>
                        <span class="summary-status">Pending</span>
                    </div>
                    <div class="summary-note">
                        <i class="fab fa-whatsapp"></i>
                        Setelah booking, hubungi kami via WhatsApp dengan menyertakan kode booking kamu.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    
</body>
</html>