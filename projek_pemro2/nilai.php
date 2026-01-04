<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Nilai</title>
    <style>
        table{border-collapse: collapse; width:80%;}
        th,td{border:1px solid #000; padding:8px;}
    </style>
</head>
<body>

<h2>Data Nilai Siswa</h2>
<a href="dashboard.php">⬅ Dashboard</a> |
<a href="input_nilai.php">➕ Input Nilai</a>
<hr>

<table>
<tr>
    <th>No</th>
    <th>Nama Siswa</th>
    <th>Kriteria</th>
    <th>Nilai</th>
    <th>Aksi</th>
</tr>

<?php
$no=1;
$q = mysqli_query($conn,"
    SELECT n.id_nilai, s.nama_siswa, k.nama_kriteria, n.nilai
    FROM nilai n
    JOIN siswa s ON n.id_siswa=s.id_siswa
    JOIN kriteria k ON n.id_kriteria=k.id_kriteria
");

while($d=mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['nama_siswa'] ?></td>
    <td><?= $d['nama_kriteria'] ?></td>
    <td><?= $d['nilai'] ?></td>
    <td>

    <td>
    <a href="edit_nilai.php?id=<?= $d['id_nilai'] ?>">Edit</a> |
    <a href="hapus_nilai.php?id=<?= $d['id_nilai'] ?>"
       onclick="return confirm('Yakin ingin menghapus nilai ini?')">
       Hapus
    </a>
</td>

</tr>
<?php } ?>
</table>

</body>
</html>
