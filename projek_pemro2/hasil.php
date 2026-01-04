<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Perangkingan</title>
    <style>
        table{
            border-collapse: collapse;
            width:100%;
        }
        th, td{
            border:1px solid black;
            padding:8px;
            text-align:center;
        }
        th{
            background:#eee;
        }
    </style>
</head>
<body>

<h2>Hasil Perangkingan Siswa Berprestasi</h2>
<a href="dashboard.php">← Kembali ke Dashboard</a>
<hr>

<table>
    <tr>
        <th>Ranking</th>
        <th>NIS</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        <th>Nilai Akademik</th>
