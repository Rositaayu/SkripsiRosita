@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail News</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('berita') }}">News</a></li>
        <li class="breadcrumb-item active">Detail Data</li>
    </ol>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">{{ $berita->judul_berita }}</h1>

                <p>By. <span class="text-muted">{{ $berita->user->name }}</span>
                </p>

                @if ($berita->foto_berita)
                <div style="max-height: 350px; overflow: hidden;">
                    <img src="{{ asset($berita->foto_berita) }}" alt="foto" class="img-fluid">
                </div>
                @endif

                <article class="my-3 fs-5">
                    {!! $berita->artikel_berita !!}
                </article>
            </div>
        </div>
    </div>
</div>
@endsection