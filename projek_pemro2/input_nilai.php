<?php
session_start();
include 'koneksi.php';

// Simpan nilai
if (isset($_POST['simpan'])) {
    $id_siswa = $_POST['id_siswa'];

    foreach ($_POST['nilai'] as $id_kriteria => $nilai) {

        // Cek apakah nilai sudah ada
        $cek = mysqli_query($conn, "
            SELECT * FROM nilai 
            WHERE id_siswa='$id_siswa' 
            AND id_kriteria='$id_kriteria'
        ");

        if (mysqli_num_rows($cek) > 0) {
            // Update
            mysqli_query($conn, "
                UPDATE nilai SET nilai='$nilai'
                WHERE id_siswa='$id_siswa'
                AND id_kriteria='$id_kriteria'
            ");
        } else {
            // Insert
            mysqli_query($conn, "
                INSERT INTO nilai (id_siswa, id_kriteria, nilai)
                VALUES ('$id_siswa', '$id_kriteria', '$nilai')
            ");
        }
    }

    echo "<script>alert('Nilai berhasil disimpan');window.location='input_nilai.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Nilai Siswa</title>
    <style>
        table{
            border-collapse: collapse;
            width:100%;
        }
        th, td{
            border:1px solid black;
            padding:8px;
        }
        th{
            background:#eee;
        }
    </style>
</head>
<body>

<h2>Input Nilai Siswa</h2>
<a href="dashboard.php">⬅ Kembali ke Dashboard</a>
<hr>

<form method="POST">
    <label>Pilih Siswa</label><br>
    <select name="id_siswa" required>
        <option value="">-- Pilih Siswa --</option>
        <?php
        $siswa = mysqli_query($conn, "SELECT * FROM siswa");
        while ($s = mysqli_fetch_assoc($siswa)) {
            echo "<option value='$s[id_siswa]'>$s[nama_siswa] - $s[kelas]</option>";
        }
        ?>
    </select>

    <br><br>

    <table>
        <tr>
            <th>No</th>
            <th>Kriteria</th>
            <th>Nilai</th>
        </tr>

        <?php
        $no = 1;
        $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
        while ($k = mysqli_fetch_assoc($kriteria)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $k['nama_kriteria'] ?></td>
            <td>
                <input type="number" name="nilai[<?= $k['id_kriteria'] ?>]" 
                       min="0" max="100" required>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <button type="submit" name="simpan">💾 Simpan Nilai</button>
</form>

</body>
</html>
