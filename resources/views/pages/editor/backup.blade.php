@push('scripts')
<script>
    // Delete
    $('#editor-table tbody').on('click', '.btn-delete', function(event) {
        event.preventDefault();
        var data = table.row($(this).parents('tr')).data();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Apakah anda yakin ingin menghapus data?',
            icon: 'warning',
            confirmButtonText: 'Ya, hapus data!',
            cancelButtonText: 'Tidak',
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var path = "{{ route('editor.destroy') }}";

                $.ajax({
                    url: path,
                    type: 'GET',
                    data: {
                        id: data.id_editor
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            confirmButtonText: 'Tutup',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                table.ajax.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data gagal dihapus.',
                            icon: 'error',
                            confirmButtonText: 'Tutup',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                        });
                    }
                });
            }
        });

    });
</script>
@endpush