@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Super Editor</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Super Editor</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Super Editor
        </div>
        <div class="card-body">

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{ route('super-editor.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
            <div class="table-responsive">
                <table id="super-editor-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Jabatan</th>
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
    let table = $('#super-editor-table').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: false,
        ajax: {
            url: "{{ route('super-editor') }}",
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
                data: 'user.name',
            },
            {
                targets: 2,
                className: 'align-middle',
                data: 'user.email',
            },
            {
                targets: 3,
                className: 'align-middle',
                data: 'alamat',
            },
            {
                targets: 4,
                className: 'align-middle',
                data: 'no_hp',
            },
            {
                targets: 5,
                className: 'align-middle',
                data: 'jabatan',
            },
            {
                targets: 6,
                className: 'align-middle',
                data: 'user.is_active',
                render: function(data, type, row, meta) {
                    return data == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>';
                }
            },
            {
                targets: 7,
                className: 'align-middle text-center',
                data: 'id_super_editor',
                render: function(data, type, row, meta) {
                    return `
                    <button type="button" class="btn btn-warning btn-edit btn-sm"><i class="fas fa-edit"></i></button>`;
                }
            },
        ],
    });

    // Edit
    $('#super-editor-table tbody').on('click', '.btn-edit', function(event) {
        event.preventDefault();
        var data = table.row($(this).parents('tr')).data();

        var path = "{{ route('super-editor.edit', ':id') }}";
        var link = path.replace(':id', data.id_super_editor);

        location.href = link;
    });
</script>
@endpush