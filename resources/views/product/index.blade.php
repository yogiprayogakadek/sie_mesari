@extends('templates.master')

@section('title', 'Produk')
@section('pwd', 'Produk')
@section('sub-pwd', 'Produk')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row render">
    {{--  --}}
</div>
@endsection

@push('script')
    <script src="{{asset('functions/main.js')}}"></script>
    <script src="https://spruko.com/demo/sash/sash/assets/plugins/select2/select2.full.min.js"></script>
    <script src="{{asset('functions/product/main.js')}}"></script>
    <script>
        function assets(url) {
            var url = '{{ url("") }}/' + url;
            return url;
        }
    </script>
@endpush