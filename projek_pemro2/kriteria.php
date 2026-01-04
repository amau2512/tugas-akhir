<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Simpan data
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $bobot  = $_POST['bobot'];
    $tipe   = $_POST['tipe'];

    mysqli_query($conn, "INSERT INTO kriteria VALUES 
        (NULL,'$nama','$bobot','$tipe')");
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM kriteria WHERE id_kriteria='$id'");
    header("Location: kriteria.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Kriteria</title>
    <style>
        body{font-family: Arial;}
        table{border-collapse: collapse; width: 60%;}
        th,td{border:1px solid #000; padding:8px;}
    </style>
</head>
<body>

<h2>Data Kriteria</h2>
<a href="dashboard.php">⬅ Kembali ke Dashboard</a>
<hr>

<form method="post">
    <input type="text" name="nama" placeholder="Nama Kriteria" required>
    <input type="number" step="0.01" name="bobot" placeholder="Bobot" required>
    <select name="tipe" required>
        <option value="">-- Tipe --</option>
        <option value="benefit">Benefit</option>
        <option value="cost">Cost</option>
    </select>
    <button name="simpan">Simpan</button>
</form>

<br>

<table>
<tr>
    <th>No</th>
    <th>Nama Kriteria</th>
    <th>Bobot</th>
    <th>Tipe</th>
    <th>Aksi</th>
</tr>

<?php
$no=1;
$data = mysqli_query($conn,"SELECT * FROM kriteria");
while($d = mysqli_fetch_array($data)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['nama_kriteria'] ?></td>
    <td><?= $d['bobot'] ?></td>
    <td><?= $d['tipe'] ?></td>
    <td>
        <a href="?hapus=<?= $d['id_kriteria'] ?>" 
           onclick="return confirm('Hapus data?')">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
