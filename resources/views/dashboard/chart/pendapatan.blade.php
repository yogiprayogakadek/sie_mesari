<div>
    <canvas id="myChart3"></canvas>
</div>

<div class="card-footer">
    <h4>
        Dari grafik diatas dapat disimpulkan pendapatan tertinggi yang di hasilkan yaitu tanggal {!!'<strong>' . $tertinggi['tanggal'] . '</strong>' !!} dengan total pendapatan   {!! '<strong>' . convertToRupiah($tertinggi['total']) . '</strong>' !!}. Sementara untuk pendapatan terendah yang di hasilkan yaitu tanggal {!!'<strong>' . $terendah['tanggal'] . '</strong>' !!}  dengan total pendapatan {!! '<strong>' . convertToRupiah($terendah['total']) . '</strong>' !!}.
    </h4>
</div>
<script>
    $('body .chart-title').html('Chart Produk');
    
    // Pendapatan
    var tanggal = [];
    var pendapatan = [];

    @foreach ($pendapatan as $i => $v)
        tanggal.push('{{$pendapatan[$i]["tanggal"]}}');
        pendapatan.push('{{$pendapatan[$i]["total"]}}');
    @endforeach

    var verticalGradientBg = {
        id: 'verticalGradientBg',
        beforeDraw(chart, args, plugins) {
            const { ctx, chartArea: {top, bottom, left, right, width, height} } = chart;

            ctx.save();

            const gradientBg = ctx.createLinearGradient(0, top, 0, height);
            gradientBg.addColorStop(0, 'rgba(0, 0, 0, 0.1)');
            gradientBg.addColorStop(0.0, 'rgba(0, 0, 0, 1)');
            gradientBg.addColorStop(0.9, 'rgba(0, 0, 0, 0.1)');
            gradientBg.addColorStop(0.9, 'rgba(0, 0, 0, 0.1)');
            gradientBg.addColorStop(1, 'rgba(0, 0, 0, 0.1)');

            ctx.fillStyle = gradientBg;
            ctx.fillRect(left, top, width, height)
        }
    }

    var data = {
        labels: tanggal,
        datasets: [{
            label: 'Pendapatan',
            data: pendapatan,
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
                    return value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
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
        // plugins: [verticalGradientBg, ChartDataLabels]
    };

    var myChart = new Chart(
        document.getElementById('myChart3').getContext('2d'),
        config
    );
</script>
