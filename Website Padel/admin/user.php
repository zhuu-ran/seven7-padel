<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM users WHERE id=" . $_GET['hapus'] . " AND role='user'");
    header('Location: user.php');
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = $search ? "AND (nama LIKE '%$search%' OR email LIKE '%$search%')" : '';

$users = mysqli_query($koneksi, "SELECT * FROM users WHERE role='user' $where ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
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
            <a href="booking.php"><i class="fa fa-calendar"></i> Booking</a>
            <a href="user.php" class="active"><i class="fa fa-users"></i> User</a>
            <a href="../auth/logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Kelola User</h1>
        </div>

        <div class="admin-card">
            <form method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari nama / email..." value="<?= $search ?>">
                <button type="submit" class="btn-admin">Cari</button>
                <?php if ($search): ?><a href="user.php" class="btn-hapus">Reset</a><?php endif; ?>
            </form>
        </div>

        <div class="admin-card">
            <h3>Daftar User</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($users)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="user.php?hapus=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
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