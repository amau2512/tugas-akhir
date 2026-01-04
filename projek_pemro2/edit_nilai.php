<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';

if ($id == '') {
    header("Location: nilai.php");
    exit;
}

// Ambil data nilai
$q = mysqli_query($conn,"
    SELECT n.id_nilai, n.nilai, s.nama_siswa, k.nama_kriteria
    FROM nilai n
    JOIN siswa s ON n.id_siswa=s.id_siswa
    JOIN kriteria k ON n.id_kriteria=k.id_kriteria
    WHERE n.id_nilai='$id'
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data tidak ditemukan");
}

// Proses update
if (isset($_POST['update'])) {
    $nilai = $_POST['nilai'];

    mysqli_query($conn,"
        UPDATE nilai SET nilai='$nilai'
        WHERE id_nilai='$id'
    ");

    header("Location: nilai.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Nilai</title>
</head>
<body>

<h2>Edit Nilai</h2>
<a href="nilai.php">⬅ Kembali</a>
<hr>

<form method="post">
    <p><b>Siswa:</b> <?= $data['nama_siswa'] ?></p>
    <p><b>Kriteria:</b> <?= $data['nama_kriteria'] ?></p>

    <label>Nilai</label><br>
    <input type="number" name="nilai" value="<?= $data['nilai'] ?>" required>
    <br><br>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
