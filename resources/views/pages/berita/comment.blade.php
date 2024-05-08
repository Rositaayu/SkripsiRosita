@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit News</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('berita') }}">News</a></li>
        <li class="breadcrumb-item active">Edit Data</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Edit News
        </div>
        <div class="card-body">
            <form action="{{ route('berita.storeComment', ['id' => $berita->id_berita]) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_kategori_berita" class="form-label">Kategori</label>
                    <select disabled class="select2 form-control @error('id_kategori_berita') is-invalid @enderror"
                        id="id_kategori_berita" name="id_kategori_berita">
                        @foreach ($kategori as $item)
                        <option {{ old('id_kategori_berita', $berita->id_kategori_berita) == $item->id_kategori_berita
                            ? 'selected' : '' }} value="{{ $item->id_kategori_berita }}">
                            {{ $item->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('id_kategori_berita')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="judul_berita" class="form-label">Judul</label>
                    <input disabled type="text" class="form-control @error('judul_berita') is-invalid @enderror"
                        id="judul_berita" name="judul_berita" value="{{ old('judul_berita', $berita->judul_berita) }}">
                    @error('judul_berita')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="artikel_berita" class="form-label">Artikel Berita</label>
                    <textarea class="form-control @error('artikel_berita') is-invalid @enderror"
                        id="artikel_berita_note" name="artikel_berita" rows="3">
                        {{ old('artikel_berita', $berita->artikel_berita) }}
                    </textarea>
                    <input type="hidden" id="artikel_berita">
                    @error('artikel_berita')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="id_tag" class="form-label">Tag</label>
                    <select disabled multiple class="select2 form-control @error('id_tag') is-invalid @enderror"
                        id="id_tag" name="id_tag[]">
                        @foreach ($tag as $item)
                        <option {{ in_array($item->id_tag, $tagBerita) ? 'selected' : '' }} value="{{ $item->id_tag
                            }}">
                            {{ $item->nama_tag }}</option>
                        @endforeach
                    </select>
                    @error('id_tag')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- List of Comments --}}
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <ul class="list-group">
                        @forelse ($komentar as $item)
                        <li class="list-group list-group-item-primary p-3 mb-3">
                            Comment {{ $loop->iteration }}
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item->user->name }}</strong>
                                    <p>{{ $item->komentar }}</p>
                                </div>
                            </div>
                            {{ $item->created_at }}
                        </li>
                        @empty
                        <li class="list-group list-group-item-primary p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>No Comment</strong>
                                </div>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <input type="text" class="form-control @error('comment') is-invalid @enderror" id="comment"
                        name="comment" value="{{ old('comment') }}">
                    @error('comment')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <a href="{{ route('berita') }}" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
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

        // Summernote
        $('#artikel_berita_note').summernote({
            height: 200
        });

        $('#artikel_berita_note').summernote('disable');
    });
</script>
@endpush