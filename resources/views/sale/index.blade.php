@extends('templates.master')

@section('title', 'Transaksi')
@section('pwd', 'Transaksi')
@section('sub-pwd', 'Transaksi')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card d-block">
            <div class="card-header">
                <div class="card-title">Data Produk</div>
            </div>
            <div class="card-body">
                <div class="form-group"> 
                    <div class="input-group"> 
                        <input type="text" class="form-control" name="slug" aria-label="Example text with button addon" aria-describedby="button-addon1"> 
                        <button class="btn btn-light btn-search" type="button" id="button-addon2">
                            <i class="fa fa-search"></i> Cari
                        </button> 
                    </div> 
                </div>

                <div class="mt-3 data-product">
                    <table class="table table-hover" id="tableProduct">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga Produk</th>
                                <th>Stok Produk</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card d-block">
            <div class="card-header">
                <div class="card-title">Keranjang Belanja</div>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="tablePCart">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Harga Produk</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- total --}}
    {{-- <div class="col-6"></div>
    <div class="col-6">
        <div class="card d-block">
            <div class="card-header">
                <div class="card-title">Keranjang Belanja</div>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="tablePCart">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Harga Produk</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@push('script')
<script src="{{asset('functions/main.js')}}"></script>
    <script src="{{asset('functions/sale/main.js')}}"></script>
    <script>
        function assets(url) {
            var url = '{{ url("") }}/' + url;
            return url;
        }
    </script>
@endpush