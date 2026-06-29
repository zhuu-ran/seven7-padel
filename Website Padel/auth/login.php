<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
        header('Location: ../admin/dashboard.php');
    }   
        else {
        $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '../index.php';
        header('Location: ../' . $redirect);
    }
        exit();
    } else {
        echo "<script>alert('Email atau password salah!'); window.history.back();</script>";
    }
}
?>