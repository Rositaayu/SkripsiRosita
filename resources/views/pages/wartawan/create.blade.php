@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Wartawan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wartawan') }}">Wartawan</a></li>
        <li class="breadcrumb-item active">Tambah Data</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Tambah Wartawan
        </div>
        <div class="card-body">
            <form action="{{ route('wartawan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        value="{{ old('nama') }}">
                    @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="id_editor" class="form-label">Editor</label>
                    <select class="select2 form-control @error('id_editor') is-invalid @enderror" id="id_editor"
                        name="id_editor">
                        <option selected disabled value="">Pilih Editor</option>
                        @foreach ($editor as $item)
                        <option value="{{ $item->id_editor }}">
                            {{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_editor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="is_active" class="form-label">Status</label>
                    <div class="form-check p-0 d-flex
                        @error('is_active') is-invalid @enderror">
                        <input class="form-check
                            @error('is_active') is-invalid @enderror" type="radio" name="is_active" id="is_active1"
                            value="1" {{ old('is_active')==1 ? 'checked' : '' }}>
                        <label class="form-check
                            @error('is_active') is-invalid @enderror" for="is_active1">
                            Aktif
                        </label>
                    </div>
                    <div class="form-check p-0 d-flex
                        @error('is_active') is-invalid @enderror">
                        <input class="form-check
                            @error('is_active') is-invalid @enderror" type="radio" name="is_active" id="is_active0"
                            value="0" {{ old('is_active')==0 ? 'checked' : '' }}>
                        <label class="form-check
                            @error('is_active') is-invalid @enderror" for="is_active0">
                            Tidak Aktif
                        </label>
                    </div>
                    @error('is_active')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <a href="{{ route('wartawan') }}" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'classic'
        });
    });
</script>
@endpush