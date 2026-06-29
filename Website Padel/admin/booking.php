<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    mysqli_query($koneksi, "UPDATE booking SET status='$status' WHERE id=$id");
    header('Location: booking.php');
    exit();
}

if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM booking WHERE id=" . $_GET['hapus']);
    header('Location: booking.php');
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = $search ? "WHERE u.nama LIKE '%$search%' OR b.kode_booking LIKE '%$search%' OR b.tanggal LIKE '%$search%'" : '';

$bookings = mysqli_query($koneksi, "
    SELECT b.*, u.nama as nama_user, s.jam_mulai, s.jam_selesai, s.harga, l.nama as nama_lapangan
    FROM booking b
    JOIN users u ON b.user_id = u.id
    JOIN slot_waktu s ON b.slot_id = s.id
    JOIN lapangan l ON s.lapangan_id = l.id
    $where
    ORDER BY b.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Booking</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="admin-body">
<div class="admin-wrapper">
    <div class="sidebar">
        <div class="sidebar-logo">SEVEN7 PADEL</div>
        <nav class="sidebar-nav">
            <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
            <a href="lapangan.php"><i class="fa fa-table-tennis-paddle-ball"></i> Lapangan</a>
            <a href="slot.php"><i class="fa fa-clock"></i> Slot Waktu</a>
            <a href="booking.php" class="active"><i class="fa fa-calendar"></i> Booking</a>
            <a href="user.php"><i class="fa fa-users"></i> User</a>
            <a href="../auth/logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Kelola Booking</h1>
        </div>

        <div class="admin-card">
            <form method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari nama / kode / tanggal..." value="<?= $search ?>">
                <button type="submit" class="btn-admin">Cari</button>
                <?php if ($search): ?><a href="booking.php" class="btn-hapus">Reset</a><?php endif; ?>
            </form>
        </div>

        <div class="admin-card">
            <h3>Daftar Booking</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>User</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($bookings)): ?>
                    <tr>
                        <td><?= $row['kode_booking'] ?></td>
                        <td><?= $row['nama_user'] ?></td>
                        <td><?= $row['nama_lapangan'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= substr($row['jam_mulai'],0,5) ?> - <?= substr($row['jam_selesai'],0,5) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><span class="badge <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                        <td>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="status" onchange="this.form.submit()" class="select-status">
                                    <option <?= $row['status']=='pending'?'selected':'' ?> value="pending">Pending</option>
                                    <option <?= $row['status']=='confirmed'?'selected':'' ?> value="confirmed">Confirmed</option>
                                    <option <?= $row['status']=='cancelled'?'selected':'' ?> value="cancelled">Cancelled</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                            <a href="booking.php?hapus=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>