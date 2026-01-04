<?php
include "koneksi.php";

echo "<h2>Data Hasil PROMETHEE (Tersimpan)</h2>";
echo "<a href='dashboard.php'>← Kembali</a><hr>";

$q = mysqli_query($conn,"
    SELECT * FROM hasil_promethee ORDER BY ranking ASC
");

echo "<table border=1 cellpadding=6 cellspacing=0>
<tr>
    <th>Ranking</th>
    <th>NIS</th>
    <th>Nama Siswa</th>
    <th>Kelas</th>
    <th>Leaving Flow</th>
    <th>Entering Flow</th>
    <th>Net Flow</th>
    <th>Keterangan</th>
</tr>";

while($d = mysqli_fetch_assoc($q)){
    echo "<tr>
        <td>{$d['ranking']}</td>
        <td>{$d['nis']}</td>
        <td>{$d['nama_siswa']}</td>
        <td>{$d['kelas']}</td>
        <td>".round($d['leaving_flow'],4)."</td>
        <td>".round($d['entering_flow'],4)."</td>
        <td><b>".round($d['net_flow'],4)."</b></td>
        <td>{$d['keterangan']}</td>
    </tr>";
}

echo "</table>";
?>
