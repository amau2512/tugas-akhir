<?php
session_start();
include 'koneksi.php';

// Proteksi login
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID nilai
$id = $_GET['id'] ?? '';

if ($id == '') {
    header("Location: nilai.php");
    exit;
}

// Hapus data nilai
mysqli_query($conn, "DELETE FROM nilai WHERE id_nilai='$id'");

// Kembali ke halaman nilai
header("Location: nilai.php");
exit;
