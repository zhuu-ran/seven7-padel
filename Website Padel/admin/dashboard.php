<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

$total_lapangan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM lapangan"));
$total_booking = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM booking"));
$total_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'user'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="img/logo.png" type="img/png">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">SEVEN7 PADEL</div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
            <a href="lapangan.php"><i class="fa fa-table-tennis-paddle-ball"></i> Lapangan</a>
            <a href="slot.php"><i class="fa fa-clock"></i> Slot Waktu</a>
            <a href="booking.php"><i class="fa fa-calendar"></i> Booking</a>
            <a href="user.php"><i class="fa fa-users"></i> User</a>
            <a href="../auth/logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Dashboard</h1>
            <span>Halo, <?= $_SESSION['nama'] ?>!</span>
        </div>

        <div class="card-grid">
            <div class="card">
                <i class="fa fa-table-tennis-paddle-ball"></i>
                <h3><?= $total_lapangan ?></h3>
                <p>Total Lapangan</p>
            </div>
            <div class="card">
                <i class="fa fa-calendar"></i>
                <h3><?= $total_booking ?></h3>
                <p>Total Booking</p>
            </div>
            <div class="card">
                <i class="fa fa-users"></i>
                <h3><?= $total_user ?></h3>
                <p>Total User</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>