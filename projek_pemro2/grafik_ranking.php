<!DOCTYPE html>
<html>
<head>
    <title>Grafik Ranking PROMETHEE</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .container {
            width: 85%;
            margin: 20px auto;
        }
        h2{
            text-align:center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Grafik Ranking Siswa - Metode PROMETHEE</h2>
    <canvas id="rankingChart"></canvas>
</div>

<script>
fetch("data_ranking.php")
.then(response => response.json())
.then(data => {

    let labels = data.map(row => row.nama_siswa);
    let netflow = data.map(row => row.net_flow);

    let ctx = document.getElementById("rankingChart");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Nilai Net Flow",
                data: netflow
            }]
        },
        options: {
            responsive: true,
            plugins:{
                legend:{display:true}
            },
            scales:{
                y:{
                    beginAtZero:true
                }
            }
        }
    });

});
</script>

</body>
</html>
