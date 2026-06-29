<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
    } else {
        $query = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', 'user')";
        
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Register berhasil! Silakan login.'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Gagal register!'); window.history.back();</script>";
        }
    }
}
?>