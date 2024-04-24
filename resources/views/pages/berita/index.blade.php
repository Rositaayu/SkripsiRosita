@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">News</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">News</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            News List
        </div>
        <div class="card-body">

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table id="news-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Editor</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Editor</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let table = $('#news-table').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: false,
        ajax: {
            url: "{{ route('berita') }}",
            type: "GET"
        },
        columnDefs: [{
                targets: 0,
                data: null,
                className: 'text-center align-middle',
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                targets: 1,
                className: 'align-middle',
                data: 'kategori.nama_kategori',
            },
            {
                targets: 2,
                className: 'align-middle',
                data: 'judul_berita',
            },
            {
                targets: 3,
                className: 'align-middle',
                data: 'user.name',
            },
            {
                targets: 4,
                className: 'align-middle',
                data: 'user.wartawan.editor.user.name',
                render: function(data, type, row, meta) {
                    return row.user.wartawan != null ? data : '-';
                }
            },
            {
                targets: 5,
                className: 'align-middle',
                data: 'created_at',
                render: function(data, type, row, meta) {
                    let date = new Date(data);
                    let month = date.getMonth() + 1;
                    let day = date.getDate();
                    let year = date.getFullYear();
                    let hour = date.getHours();
                    let minute = date.getMinutes();
                    let second = date.getSeconds();

                    return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
                }
            },
            {
                targets: 6,
                className: 'align-middle',
                data: 'status_berita',
                render: function(data, type, row, meta) {
                    return data == 0 ? '<span class="badge bg-warning">Review</span>' : data == 1 ? '<span class="badge bg-secondary">Pending</span>' : data == 2 ? '<span class="badge bg-danger">On Progress</span>' : '<span class="badge bg-success">Published</span>';
                }
            },
            {
                targets: 7,
                className: 'align-middle text-center',
                data: 'id_berita',
                render: function(data, type, row, meta) {
                    return ''
                    @can('super_editor')
                    + `<button type="button" class="btn btn-warning btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-info btn-show btn-sm"><i class="fas fa-eye"></i></button>
                    ${row.status_berita == 1 ? `<button type="button" class="btn btn-secondary btn-comment btn-sm"><i class="fas fa-comments"></i></button>` : ''}`;
                    @endcan
                    
                    @can('editor')
                    + row.user.wartawan.id_editor == @json(auth()->user()->editor->id_editor) ? ` <button type="button" class="me-1 btn btn-warning btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-info btn-show btn-sm"><i class="fas fa-eye"></i></button> ${row.status_berita == 1 ? `<button type="button" class="btn btn-secondary btn-comment btn-sm"><i class="fas fa-comments"></i></button>` : ''}` : `<button type="button" class="btn btn-info btn-show btn-sm"><i class="fas fa-eye"></i></button>`;
                    @endcan

                    @can('wartawan')
                    + `<button type="button" class="btn btn-info btn-show btn-sm"><i class="fas fa-eye text-white"></i></button>
                    ${row.status_berita == 1 ? `<button type="button" class="btn btn-warning btn-edit btn-sm"><i class="fas fa-edit"></i></button>` : ''}
                    ${row.komentar.length != 0 ? `<button type="button" class="btn btn-secondary btn-comment btn-sm"><i class="fas fa-comments"></i></button>` : ''}
                    `;
                    @endcan
                }
            },
        ],
    });

    // Edit
    $('#news-table tbody').on('click', '.btn-edit', function(event) {
        event.preventDefault();
        var data = table.row($(this).parents('tr')).data();

        var path = "{{ route('berita.edit', ':id') }}";
        var link = path.replace(':id', data.id_berita);

        location.href = link;
    });
    
    // comment
    $('#news-table tbody').on('click', '.btn-comment', function(event) {
        event.preventDefault();
        var data = table.row($(this).parents('tr')).data();

        var path = "{{ route('berita.comment', ':id') }}";
        var link = path.replace(':id', data.id_berita);

        location.href = link;
    });

    // Show
    $('#news-table tbody').on('click', '.btn-show', function(event) {
        event.preventDefault();
        var data = table.row($(this).parents('tr')).data();

        var path = "{{ route('berita.show', ':id') }}";
        var link = path.replace(':id', data.id_berita);

        location.href = link;
    });
</script>
@endpush