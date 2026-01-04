<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    mysqli_query($conn,"INSERT INTO siswa VALUES 
    (NULL,'$_POST[nis]','$_POST[nama]','$_POST[kelas]')");
}
?>

<form method="post">
<input name="nis" placeholder="NIS">
<input name="nama" placeholder="Nama">
<input name="kelas" placeholder="Kelas">
<button name="simpan">Simpan</button>
</form>

<?php
$data = mysqli_query($conn,"SELECT * FROM siswa");
while($d=mysqli_fetch_array($data)){
    echo $d['nama_siswa']."<br>";
}
?>
