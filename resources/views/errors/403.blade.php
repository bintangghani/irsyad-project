@extends('layouts/dashboard')

@section('title', '403 Forbidden')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4 text-danger">403</h1>
    <p class="lead">Oops! Kamu tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
