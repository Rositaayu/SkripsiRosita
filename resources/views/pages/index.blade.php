@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4>Selamat Datang,</h4>
                <hr>
                <strong>{{ auth()->user()->name }}, </strong>selamat bekerja dan tetap semangat
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white text-center mb-4">
                <div class="card-body">Publish</div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <h3>{{ $jumlahPublish }} Berita</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white text-center mb-4">
                <div class="card-body">Review</div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <h3>{{ $jumlahReview }} Berita</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white text-center mb-4">
                <div class="card-body">On Progress</div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <h3>{{ $jumlahProgress }} Berita</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white text-center mb-4">
                <div class="card-body">Pending</div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <h3>{{ $jumlahPending }} Berita</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection