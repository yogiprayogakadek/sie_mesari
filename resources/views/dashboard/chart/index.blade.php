<div>
    <canvas id="myChart"></canvas>
</div>

<div class="card-footer">
    {{-- <h4>
        Dari grafik diatas dapat disimpulkan produk yang terjual paling banyak pada bulan {!!'<strong>' . $bulan . '</strong>' !!} tahun {!!'<strong>' . $tahun . '</strong>' !!} adalah {!! '<strong>' . $tertinggiProduk . '</strong>' !!} dengan total penjualan {!! '<strong>' . $tertinggiValue . '</strong>' !!} buah. Sementara untuk produk yang terjual paling sedikit pada bulan {!!'<strong>' . $bulan . '</strong>' !!} tahun {!!'<strong>' . $tahun . '</strong>' !!} adalah {!! '<strong>' . $terendahProduk . '</strong>' !!} dengan total penjualan masing - masing {!! '<strong>' . $terendahValue . '</strong>' !!} buah.
    </h4> --}}

    <h4>
        Dari grafik diatas dapat disimpulkan produk yang terjual paling banyak pada tanggal {!!'<strong>' . $tanggal . '</strong>' !!}  adalah {!! '<strong>' . $tertinggi . '</strong>' !!}. Sementara untuk produk yang terjual paling sedikit pada tanggal {!!'<strong>' . $tanggal . '</strong>' !!}  adalah {!! '<strong>' . $terendah . '</strong>' !!}.
    </h4>
</div>
<script>
    @if ($totalData == 0)
        $('body .render').html('<div class="alert alert-danger text-center">Tidak ada data pada bulan ini</div>');
    @endif

    $('body .chart-title').html('Chart Produk');

    var label = [];
    var jumlah = [];

    @foreach ($chart as $key => $value)
        label.push('{{$chart[$key]["nama_produk"]}}');
        jumlah.push('{{$chart[$key]["jumlah"]}}');
    @endforeach

    var data = {
        labels: label,
        datasets: [{
            label: 'Penjualan',
            data: jumlah,
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

    var options = {
        plugins: {
            datalabels: {
                anchor: 'end', // Position the label at the end of the bar
                align: 'top', // Position the label on top of the bar
                color: 'red',
                font: {
                    weight: 'bold',
                    size: '14pt'
                },
                formatter: function(value, context) {
                    return value;
                    
                    // if (context.dataIndex === context.chart.data.datasets[0].data.length - 1) {
                    //     // console.log(context.chart.data.datasets[0].data[context.chart.data.datasets[0].data.length - 1])
                    //     // Show the sum of all data points on top
                    //     const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    //     // return total;
                    //     // return 'Total: ' + total;
                    //     return context.chart.data.datasets[0].data[context.chart.data.datasets[0].data.length - 1];
                    // } else {
                    //     // return value;
                    //     // return context.chart.data.labels[context.dataIndex] + ': ' + value;
                    //     return value;
                    // }
                }
            },
            tooltip: {
                enabled: false
            }
        }
    };

    var config = {
        type: 'bar',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    };

    var myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>