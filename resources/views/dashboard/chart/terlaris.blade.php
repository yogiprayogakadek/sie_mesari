<div>
    <canvas id="myChart2"></canvas>
</div>

<div class="card-footer">
    <h4>
        Dari grafik diatas dapat disimpulkan produk yang terlaris pada tanggal {!!'<strong>' . $tanggal . '</strong>' !!}  adalah {!! '<strong>' . $produk . '</strong>' !!}. dengan jumlah masing - masing sebagai berikut {!! '<strong>' . $kuantitas . '</strong>' !!}.
    </h4>
</div>
<script>
    $('body .chart-title').html('Chart Produk');
    
    // Terlaris
    var produk = [];
    var kuantitas = [];

    @foreach ($terlaris as $i => $v)
        produk.push('{{$terlaris[$i]["nama_produk"]}}');
        kuantitas.push('{{$terlaris[$i]["kuantitas"]}}');
    @endforeach

    var data = {
        labels: produk,
        datasets: [{
            label: 'Penjualan Terlaris',
            data: kuantitas,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    var config = {
        type: 'doughnut',
        data: data,
    };

    var myChart = new Chart(
        document.getElementById('myChart2').getContext('2d'),
        config
    );
</script>
