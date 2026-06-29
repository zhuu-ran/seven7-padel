<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['tambah'])) {
    $lapangan_id = $_POST['lapangan_id'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $harga = $_POST['harga'];
    mysqli_query($koneksi, "INSERT INTO slot_waktu (lapangan_id, jam_mulai, jam_selesai, harga) VALUES ('$lapangan_id', '$jam_mulai', '$jam_selesai', '$harga')");
    header('Location: slot.php');
    exit();
}

if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM slot_waktu WHERE id = " . $_GET['hapus']);
    header('Location: slot.php');
    exit();
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $lapangan_id = $_POST['lapangan_id'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $harga = $_POST['harga'];
    mysqli_query($koneksi, "UPDATE slot_waktu SET lapangan_id='$lapangan_id', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai', harga='$harga' WHERE id=$id");
    header('Location: slot.php');
    exit();
}

$slots = mysqli_query($koneksi, "SELECT s.*, l.nama as nama_lapangan FROM slot_waktu s JOIN lapangan l ON s.lapangan_id = l.id ORDER BY l.nama, s.jam_mulai");
$lapangan = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE status='aktif'");
$lapangan_list = [];
while ($l = mysqli_fetch_assoc($lapangan)) $lapangan_list[] = $l;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Slot Waktu</title>
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
            <a href="slot.php" class="active"><i class="fa fa-clock"></i> Slot Waktu</a>
            <a href="booking.php"><i class="fa fa-calendar"></i> Booking</a>
            <a href="user.php"><i class="fa fa-users"></i> User</a>
            <a href="../auth/logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Kelola Slot Waktu</h1>
        </div>

        <div class="admin-card">
            <h3>Tambah Slot</h3>
            <form method="POST" class="admin-form">
                <select name="lapangan_id" required>
                    <option value="">Pilih Lapangan</option>
                    <?php foreach ($lapangan_list as $l): ?>
                    <option value="<?= $l['id'] ?>"><?= $l['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="time" name="jam_mulai" required>
                <input type="time" name="jam_selesai" required>
                <input type="number" name="harga" placeholder="Harga (Rp)" required>
                <button type="submit" name="tambah" class="btn-admin">Tambah</button>
            </form>
        </div>

        <div class="admin-card">
            <h3>Daftar Slot</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lapangan</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($slots)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_lapangan'] ?></td>
                        <td><?= $row['jam_mulai'] ?></td>
                        <td><?= $row['jam_selesai'] ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <button class="btn-edit" onclick="openEdit(<?= $row['id'] ?>, <?= $row['lapangan_id'] ?>, '<?= $row['jam_mulai'] ?>', '<?= $row['jam_selesai'] ?>', <?= $row['harga'] ?>)">Edit</button>
                            <a href="slot.php?hapus=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <span class="modal-close" onclick="closeEdit()">&times;</span>
        <h2>Edit Slot</h2>
        <form method="POST" class="admin-form">
            <input type="hidden" name="id" id="editId">
            <select name="lapangan_id" id="editLapangan" required>
                <?php foreach ($lapangan_list as $l): ?>
                <option value="<?= $l['id'] ?>"><?= $l['nama'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="time" name="jam_mulai" id="editMulai" required>
            <input type="time" name="jam_selesai" id="editSelesai" required>
            <input type="number" name="harga" id="editHarga" placeholder="Harga" required>
            <button type="submit" name="edit" class="btn-admin">Simpan</button>
        </form>
    </div>
</div>

<script>
function openEdit(id, lapangan_id, jam_mulai, jam_selesai, harga) {
    document.getElementById('editId').value = id;
    document.getElementById('editLapangan').value = lapangan_id;
    document.getElementById('editMulai').value = jam_mulai;
    document.getElementById('editSelesai').value = jam_selesai;
    document.getElementById('editHarga').value = harga;
    document.getElementById('modalEdit').classList.add('active');
}
function closeEdit() {
    document.getElementById('modalEdit').classList.remove('active');
}
</script>
</body>
</html>