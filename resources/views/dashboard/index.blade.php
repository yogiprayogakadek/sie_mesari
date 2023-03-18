@extends('templates.master')

@section('title', 'Dashboard')
@section('pwd', 'Dashboard')
@section('sub-pwd', 'Data')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="alert alert-info">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Hai!</strong>
            Selamat datang, {{username()}}
        </div>
        <div class="row">
            @foreach (menu() as $key => $menu)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-2">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Jumlah {{indoMenu()[$key]}}</h6>
                                <h2 class="mb-0 number-font">{{totalData($menu)}}</h2>
                            </div>
                        </div>
                        <a href="{{route(RouteUrl()[$key])}}">
                            <span class="text-muted fs-12">
                                <span class="text-secondary">
                                    <i class="fe fe-arrow-right-circle text-secondary"></i> Detail
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                    {{-- <div class="card-header bg-info-transparent card-transparent"> --}}
                        <h3 class="card-title text-info chart-title">Grafik Penjualan Produk</h3>
                        <div class="card-options">
                            <div class="form-group">
                                <select class="form-control" id="filter" hidden>
                                    <option value="">Pilih Filter</option>
                                    <option value="product" selected>Berdasarkan Produk</option>
                                    <option value="category">Berdasarkan Kategori</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="date" name="start_date" id="start_date" class="form-control start_date" placeholder="tanggal awal">
                                -
                            </div>
                            <div class="form-group">
                                <input type="date" name="end_date" id="end_date" class="form-control end_date" placeholder="tanggal akhir">
                            </div>
                            <div class="form-group" style="margin-left: 4px">
                                <button class="btn btn-primary btn-lg" id="btn-search">
                                    <i class="fe fe-refresh-cw"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body render">
                        <h6 class="text-center">
                            Chart akan tampil disini
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Chart 5 Produk Terlaris</h6>
                    </div>
                    <div class="card-body render-terlaris">
                        <h6 class="text-center">
                            Chart akan tampil disini
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-2">
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Chart Pendapatan</h6>
                    </div>
                    <div class="card-body render-pendapatan">
                        <h6 class="text-center">
                            Chart akan tampil disini
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    $(document).ready(function(){
        flatpickr('#start_date', {
            dateFormat: "d-m-Y"
        })

        flatpickr('#end_date', {
            dateFormat: "d-m-Y"
        })

        function renderChart(start_date, end_date, filter) {
            $('.render').empty()
            if(start_date == '' || end_date == '' || filter == ''){
                $('.render').html('<div class="text-center"><h4>Tidak ada data</h4></div>')
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf...',
                    text: 'Pilih Bulan dan Tahun atu Filter terlebih dahulu!',
                });
            }else{
                $.ajax({
                    url: "{{route('dashboard.chart')}}",
                    type: 'POST',
                    data: {
                        filter: filter,
                        start_date: start_date,
                        end_date: end_date,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(data){
                        $('.render').html(data.data);
                    }
                });
            }
        }

        function renderChartTerlaris(start_date, end_date, filter) {
            $('.render-terlaris').empty()
            // if(bulan == '' || tahun == '' || filter == ''){
            if(start_date == '' || end_date == '' || filter == ''){
                $('.render-terlaris').html('<div class="text-center"><h4>Tidak ada data</h4></div>')
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf...',
                    text: 'Pilih tanggal pencarian!',
                });
            }else{
                $.ajax({
                    url: "{{route('dashboard.chart.terlaris')}}",
                    type: 'POST',
                    data: {
                        filter: filter,
                        start_date: start_date,
                        end_date: end_date,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(data){
                        $('.render-terlaris').html(data.data);
                    }
                });
            }
        }

        function renderChartPendapatan(start_date, end_date, filter) {
            $('.render-pendapatan').empty()
            // if(bulan == '' || tahun == '' || filter == ''){
            if(start_date == '' || end_date == '' || filter == ''){
                $('.render-pendapatan').html('<div class="text-center"><h4>Tidak ada data</h4></div>')
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf...',
                    text: 'Pilih tanggal pencarian!',
                });
            }else{
                $.ajax({
                    url: "{{route('dashboard.chart.pendapatan')}}",
                    type: 'POST',
                    data: {
                        filter: filter,
                        start_date: start_date,
                        end_date: end_date,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(data){
                        $('.render-pendapatan').html(data.data);
                    }
                });
            }
        }

        $('#btn-search').click(function(){
            $('.render').empty()
            $('.render-terlaris').empty()
            $('.render-pendapatan').empty()

            $('.render').empty()
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var filter = $('#filter').val();
            renderChart(start_date, end_date, filter);
            renderChartTerlaris(start_date, end_date, filter);
            renderChartPendapatan(start_date, end_date, filter);
        });
    });
</script>
@endpush