<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Tambah lapangan
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];
    $foto = '';

    if ($_FILES['foto']['name'] != '') {
        $foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], '../img/' . $foto);
    }

    mysqli_query($koneksi, "INSERT INTO lapangan (nama, lokasi, foto, status) VALUES ('$nama', '$lokasi', '$foto', '$status')");
    header('Location: lapangan.php');
    exit();
}

// Hapus lapangan
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM lapangan WHERE id = " . $_GET['hapus']);
    header('Location: lapangan.php');
    exit();
}

// Edit lapangan
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];

    if ($_FILES['foto']['name'] != '') {
        $foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], '../img/' . $foto);
        mysqli_query($koneksi, "UPDATE lapangan SET nama='$nama', lokasi='$lokasi', foto='$foto', status='$status' WHERE id=$id");
    } else {
        mysqli_query($koneksi, "UPDATE lapangan SET nama='$nama', lokasi='$lokasi', status='$status' WHERE id=$id");
    }
    header('Location: lapangan.php');
    exit();
}

$lapangan = mysqli_query($koneksi, "SELECT * FROM lapangan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Lapangan</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="admin-body">
<div class="admin-wrapper">
    <div class="sidebar">
        <div class="sidebar-logo">SEVEN7 PADEL</div>
        <nav class="sidebar-nav">
            <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
            <a href="lapangan.php" class="active"><i class="fa fa-table-tennis-paddle-ball"></i> Lapangan</a>
            <a href="slot.php"><i class="fa fa-clock"></i> Slot Waktu</a>
            <a href="booking.php"><i class="fa fa-calendar"></i> Booking</a>
            <a href="user.php"><i class="fa fa-users"></i> User</a>
            <a href="../auth/logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Kelola Lapangan</h1>
        </div>

        <!-- Form Tambah -->
        <div class="admin-card">
            <h3>Tambah Lapangan</h3>
            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="text" name="nama" placeholder="Nama Lapangan" required>
                <input type="text" name="lokasi" placeholder="Lokasi" required>
                <select name="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <input type="file" name="foto" accept="image/*">
                <button type="submit" name="tambah" class="btn-admin">Tambah</button>
            </form>
        </div>

        <!-- Tabel -->
        <div class="admin-card">
            <h3>Daftar Lapangan</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($lapangan)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?php if ($row['foto']): ?><img src="../img/<?= $row['foto'] ?>" width="60" style="border-radius:6px"><?php else: ?>-<?php endif; ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['lokasi'] ?></td>
                        <td><span class="badge <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                        <td>
                            <button class="btn-edit" onclick="openEdit(<?= $row['id'] ?>, '<?= $row['nama'] ?>', '<?= $row['lokasi'] ?>', '<?= $row['status'] ?>')">Edit</button>
                            <a href="lapangan.php?hapus=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
        <h2>Edit Lapangan</h2>
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="nama" id="editNama" placeholder="Nama Lapangan" required>
            <input type="text" name="lokasi" id="editLokasi" placeholder="Lokasi" required>
            <select name="status" id="editStatus">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
            <input type="file" name="foto" accept="image/*">
            <button type="submit" name="edit" class="btn-admin">Simpan</button>
        </form>
    </div>
</div>

<script>
function openEdit(id, nama, lokasi, status) {
    document.getElementById('editId').value = id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editLokasi').value = lokasi;
    document.getElementById('editStatus').value = status;
    document.getElementById('modalEdit').classList.add('active');
}
function closeEdit() {
    document.getElementById('modalEdit').classList.remove('active');
}
</script>
</body>
</html>