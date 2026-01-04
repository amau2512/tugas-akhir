<?php
include "koneksi.php";

$data = [];

$q = mysqli_query($koneksi, "
    SELECT nama_siswa, net_flow, ranking
    FROM hasil_promethee
    ORDER BY ranking ASC
");

while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
