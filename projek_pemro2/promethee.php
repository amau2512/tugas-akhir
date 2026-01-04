<?php
include "koneksi.php";

// =============================
// AMBIL DATA KRITERIA
// =============================
$kriteria = [];
$qk = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while($r = mysqli_fetch_assoc($qk)){
    $kriteria[$r['id_kriteria']] = [
        'kode' => $r['kode_kriteria'],
        'nama' => $r['nama_kriteria'],
        'bobot' => $r['bobot'],
        'tipe' => $r['tipe']   // benefit / cost
    ];
}

// =============================
// AMBIL DATA SISWA
// =============================
$siswa = [];
$qs = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama_siswa ASC");
while($r = mysqli_fetch_assoc($qs)){
    $siswa[$r['id_siswa']] = [
        'nis' => $r['nis'],
        'nama' => $r['nama_siswa'],
        'kelas' => $r['kelas']
    ];
}

// =============================
// AMBIL DATA NILAI
// =============================
$nilai = [];
$qn = mysqli_query($conn, "SELECT * FROM nilai");
while($r = mysqli_fetch_assoc($qn)){
    $nilai[$r['id_siswa']][$r['id_kriteria']] = $r['nilai'];
}

// =============================
// MATRIX PREFERENSI PROMETHEE
// =============================
$phi_plus = [];
$phi_minus = [];

foreach($siswa as $i => $si){
    foreach($siswa as $j => $sj){

        if($i == $j) continue;

        $pref_ij = 0;
        $pref_ji = 0;

        foreach($kriteria as $idk => $k){

            $vi = $nilai[$i][$idk];
            $vj = $nilai[$j][$idk];

            if($k['tipe'] == "benefit"){
                $p = max(0, $vi - $vj);
                $q = max(0, $vj - $vi);
            } else {
                $p = max(0, $vj - $vi);
                $q = max(0, $vi - $vj);
            }

            $pref_ij += $p * $k['bobot'];
            $pref_ji += $q * $k['bobot'];
        }

        $phi_plus[$i]  = ($phi_plus[$i]  ?? 0) + $pref_ij;
        $phi_minus[$i] = ($phi_minus[$i] ?? 0) + $pref_ji;
    }
}

// =============================
// HITUNG NET FLOW
// =============================
$netflow = [];
foreach($siswa as $id => $s){
    $phi_plus[$id]  = $phi_plus[$id]  ?? 0;
    $phi_minus[$id] = $phi_minus[$id] ?? 0;

    $netflow[$id] = $phi_plus[$id] - $phi_minus[$id];
}

// =============================
// URUTKAN BERDASARKAN NETFLOW DESC
// =============================
arsort($netflow);

// =============================
// SIMPAN ULANG HASIL KE DATABASE
// =============================
mysqli_query($conn, "TRUNCATE TABLE hasil_promethee");

$rank = 1;

foreach($netflow as $id => $nf){

    $ket = ($rank <= 3) ? "Siswa Berprestasi" : "Cadangan";

    $q = mysqli_query($conn,"
        INSERT INTO hasil_promethee
        (id_siswa, nis, nama_siswa, kelas,
        leaving_flow, entering_flow, net_flow,
        ranking, keterangan)
        VALUES (
            '$id',
            '".$siswa[$id]['nis']."',
            '".$siswa[$id]['nama']."',
            '".$siswa[$id]['kelas']."',
            '".$phi_plus[$id]."',
            '".$phi_minus[$id]."',
            '$nf',
            '$rank',
            '$ket'
        )
    ");

    if(!$q){
        echo "<pre>QUERY ERROR:\n".mysqli_error($conn)."</pre>";
    }

    $rank++;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Hasil Perangkingan PROMETHEE</title>
<link rel="stylesheet" href="assets/bootstrap.min.css">
</head>

<body class="container mt-4">

<h3>Hasil Perangkingan Metode PROMETHEE</h3>
<hr>

<a href="export_laporan_promethee.php"
   class="btn btn-danger mb-3"
   target="_blank">
   Export PDF Laporan Akhir
</a>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>Rank</th>
    <th>NIS</th>
    <th>Nama Siswa</th>
    <th>Kelas</th>
    <th>Leaving Flow (Phi+)</th>
    <th>Entering Flow (Phi-)</th>
    <th>Net Flow</th>
    <th>Keterangan</th>
</tr>
</thead>

<tbody>
<?php
$q = mysqli_query($conn,"
    SELECT * FROM hasil_promethee
    ORDER BY ranking ASC
");

while($d = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $d['ranking']; ?></td>
    <td><?= $d['nis']; ?></td>
    <td><?= $d['nama_siswa']; ?></td>
    <td><?= $d['kelas']; ?></td>
    <td><?= number_format($d['leaving_flow'],4); ?></td>
    <td><?= number_format($d['entering_flow'],4); ?></td>
    <td><b><?= number_format($d['net_flow'],4); ?></b></td>

    <td>
        <?php if($d['ranking'] <= 3){ ?>
            <span class="badge bg-success">Siswa Berprestasi</span>
        <?php } else { ?>
            <span class="badge bg-secondary">Cadangan</span>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

</body>
</html>
