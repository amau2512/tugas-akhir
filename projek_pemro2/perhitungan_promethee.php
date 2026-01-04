<?php
include 'koneksi.php';

/* ===============================
   AMBIL DATA SISWA & KRITERIA
================================ */
$siswa_q = mysqli_query($conn, "SELECT * FROM siswa");
$kriteria_q = mysqli_query($conn, "SELECT * FROM kriteria");

$siswa = [];
while ($row = mysqli_fetch_assoc($siswa_q)) {
    $siswa[] = $row;
}

$kriteria = [];
while ($row = mysqli_fetch_assoc($kriteria_q)) {
    $kriteria[] = $row;
}

/* ===============================
   INISIALISASI ARRAY
================================ */
$phi = [];
$flow = [];

/* ===============================
   HITUNG PREFERENSI PROMETHEE
================================ */
foreach ($siswa as $s1) {
    foreach ($siswa as $s2) {

        if ($s1['id_siswa'] == $s2['id_siswa']) continue;

        $total_pref = 0;

        foreach ($kriteria as $k) {

            $q1 = mysqli_query($conn, "
                SELECT nilai FROM nilai 
                WHERE id_siswa='{$s1['id_siswa']}' 
                AND id_kriteria='{$k['id_kriteria']}'
            ");
            $q2 = mysqli_query($conn, "
                SELECT nilai FROM nilai 
                WHERE id_siswa='{$s2['id_siswa']}' 
                AND id_kriteria='{$k['id_kriteria']}'
            ");

            $n1 = mysqli_fetch_assoc($q1);
            $n2 = mysqli_fetch_assoc($q2);

            $v1 = $n1 ? $n1['nilai'] : 0;
            $v2 = $n2 ? $n2['nilai'] : 0;

            // Fungsi preferensi sederhana
            if ($k['tipe'] == 'benefit') {
                $pref = max(0, $v1 - $v2);
            } else {
                $pref = max(0, $v2 - $v1);
            }

            $total_pref += $pref * $k['bobot'];
        }

        $phi[$s1['id_siswa']][] = $total_pref;
    }
}

/* ===============================
   HITUNG NET FLOW
================================ */
foreach ($phi as $id => $nilai) {
    $flow[$id] = array_sum($nilai) / count($nilai);
}

/* ===============================
   SORTING RANKING
================================ */
arsort($flow);
?>
