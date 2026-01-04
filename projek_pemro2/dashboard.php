<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['role'])){
    header("location:login.php");
    exit;
}

// Hitung jumlah data
$jml_siswa   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM siswa"));
$jml_kriteria= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM kriteria"));
$jml_nilai   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM nilai"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | SPK PROMETHEE</title>
    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
        }
        .box{
            width:200px;
            padding:20px;
            background:#fff;
            float:left;
            margin:10px;
            box-shadow:0 0 5px #ccc;
            text-align:center;
        }
        .menu{
            background:#343a40;
            padding:10px;
        }
        .menu a{
            color:white;
            margin-right:15px;
            text-decoration:none;
            font-weight:bold;
        }
        h2{ margin-top:0; }
    </style>
</head>
<body>

<div class="menu">
    <a href="dashboard.php">Dashboard</a>
    <a href="siswa.php">Data Siswa</a>
    <a href="kriteria.php">Data Kriteria</a>
    <a href="nilai.php">Input Nilai</a>
    <a href="hasil.php">Hasil Perangkingan</a>
    <a href="logout.php">Logout</a>
</div>

<h2>Dashboard Sistem Penunjang Keputusan</h2>
<p>
    Metode PROMETHEE untuk Penilaian Siswa Berprestasi  
    <br><b>SMA Negeri 8 Tangerang Selatan</b>
</p>

<div class="box">
    <h3><?=$jml_siswa?></h3>
    <p>Jumlah Siswa</p>
</div>

<div class="box">
    <h3><?=$jml_kriteria?></h3>
    <p>Jumlah Kriteria</p>
</div>

<div class="box">
    <h3><?=$jml_nilai?></h3>
    <p>Data Penilaian</p>
</div>

<div style="clear:both"></div>

<hr>

<h3>Hak Akses</h3>
<p>
    Anda login sebagai <b><?=strtoupper($_SESSION['role'])?></b>
</p>

</body>
</html>
