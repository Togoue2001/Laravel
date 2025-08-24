@extends('admin.dashboard')

@section('navbar')
    <div class="d-flex justify-content-between align-items-center">
        <h1><strong>Code Promo</strong></h1>
    </div>
@endsection

@section('container')
<div class="container mt-4">
    @include('admin.coupons.form')
</div>
@endsection
