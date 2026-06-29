<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['id'])) { header('Location: index.php'); exit(); }

$kode = isset($_GET['kode']) ? $_GET['kode'] : '';
$booking = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT b.*, s.jam_mulai, s.jam_selesai, s.harga, l.nama as nama_lapangan, l.lokasi
    FROM booking b
    JOIN slot_waktu s ON b.slot_id = s.id
    JOIN lapangan l ON s.lapangan_id = l.id
    WHERE b.kode_booking='$kode' AND b.user_id=".$_SESSION['id']
));
if (!$booking) { header('Location: index.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil - SEVEN7 PADEL</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="sukses-page">
        <div class="sukses-card">
            <div class="sukses-icon"><i class="fa fa-circle-check"></i></div>
            <h2>Booking Berhasil!</h2>
            <p>Catat kode booking kamu di bawah ini</p>

            <div class="kode-booking"><?= $kode ?></div>

            <div class="sukses-detail">
                <div class="sukses-row">
                    <span>Lapangan</span>
                    <span><?= $booking['nama_lapangan'] ?></span>
                </div>
                <div class="sukses-row">
                    <span>Tanggal</span>
                    <span><?= date('d F Y', strtotime($booking['tanggal'])) ?></span>
                </div>
                <div class="sukses-row">
                    <span>Waktu</span>
                    <span><?= substr($booking['jam_mulai'],0,5) ?> - <?= substr($booking['jam_selesai'],0,5) ?></span>
                </div>
                <div class="sukses-row">
                    <span>Harga</span>
                    <span>Rp <?= number_format($booking['harga'],0,',','.') ?></span>
                </div>
                <div class="sukses-row">
                    <span>Status</span>
                    <span class="summary-status">Pending</span>
                </div>
            </div>

            <div class="sukses-note">
                <i class="fab fa-whatsapp"></i>
                Hubungi kami via WhatsApp dengan menyertakan kode booking <strong><?= $kode ?></strong> untuk konfirmasi.
            </div>

            <div class="sukses-actions">
                <a href="https://wa.me/6281320350419?text=Halo, saya ingin konfirmasi booking dengan kode <?= $kode ?>" target="_blank" class="btn-wa">
                    <i class="fab fa-whatsapp"></i> Chat WhatsApp
                </a>
                <a href="index.php" class="btn-cek">Kembali ke Home</a>
            </div>
        </div>
    </div>
</body>
</html>