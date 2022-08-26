@extends('templates.master')

@section('title', 'Kategori')
@section('pwd', 'Kategori')
@section('sub-pwd', 'Kategori')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="row render">
    {{--  --}}
</div>
@endsection

@push('script')
    <script src="{{asset('functions/category/main.js')}}"></script>
    <script>
        function assets(url) {
            var url = '{{ url("") }}/' + url;
            return url;
        }
    </script>
@endpush