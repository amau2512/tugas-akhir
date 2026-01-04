<?php
session_start();
include 'koneksi.php';

// Proteksi akses
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah form disubmit
if (!isset($_POST['simpan'])) {
    header("Location: nilai.php");
    exit;
}

// Validasi input
$id_siswa = $_POST['siswa'] ?? '';

if ($id_siswa == '') {
    die("Siswa belum dipilih!");
}

// Simpan nilai
foreach ($_POST['nilai'] as $id_kriteria => $nilai) {

    // Cegah nilai kosong
    $nilai = $nilai == '' ? 0 : $nilai;

    // Cek apakah nilai sudah ada
    $cek = mysqli_query($conn,"
        SELECT * FROM nilai 
        WHERE id_siswa='$id_siswa' 
        AND id_kriteria='$id_kriteria'
    ");

    if (mysqli_num_rows($cek) > 0) {
        // Update nilai
        mysqli_query($conn,"
            UPDATE nilai 
            SET nilai='$nilai' 
            WHERE id_siswa='$id_siswa' 
            AND id_kriteria='$id_kriteria'
        ");
    } else {
        // Insert nilai
        mysqli_query($conn,"
            INSERT INTO nilai (id_siswa,id_kriteria,nilai)
            VALUES ('$id_siswa','$id_kriteria','$nilai')
        ");
    }
}

header("Location: nilai.php?status=sukses");
exit;
