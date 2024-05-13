@extends('layouts.main')

@push('styles')
<style>
    .bd-callout-info {
        border-left-color: #5bc0de !important;
    }

    .bd-callout {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        border: 1px solid #e9ecef;
        border-left-width: .25rem;
        border-radius: .25rem;
        background-color: rgba(91, 192, 222, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4>Selamat Datang</h4>
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
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Kategori Berita
                </div>
                <div class="card-body">
                    <h3>GRAFIK JUMLAH ARTIKEL BERITA BERDASARKAN KATEGORI BERITA</h3>
                        <br>
                        <div class="bd-callout bd-callout-info">
                        Berikut ini adalah statistik data poin yang telah dikelompokkan berdasarkan kategori berita dari artikel yang masuk pada sistem, disajikan dalam bentuk diagram pai.
                        Untuk menampilkan data kategori berita berdasarkan per hari, per minggu, per bulan, silahkan pilih filter yang dibutuhkan. Untuk menampilkan data detailnya, silahkan klik pada bagian grafik.
                    </div>
                        
                    <!-- Dropdown untuk filter -->
                    <select class="select2 form-control" id="filter-kategori">
                        <option value="bulan">Per Bulan</option>
                        <option value="hari">Per Hari</option>
                        <option value="minggu">Per Minggu</option>
                    </select>
                    <hr>
                    <canvas id="kategori" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Tag Berita
                </div>
                <div class="card-body">
                <h3>GRAFIK JUMLAH ARTIKEL BERITA BERDASARKAN TAG BERITA</h3>
                        <br>
                        <div class="bd-callout bd-callout-info">
                            Berikut ini adalah statistik data poin yang telah dikelompokkan berdasarkan tag berita dari artikel yang masuk pada sistem, disajikan dalam bentuk diagram batang.
                            Untuk menampilkan data tag berita berdasarkan per hari, per minggu, per bulan, silahkan pilih filter yang dibutuhkan. Untuk menampilkan data detailnya, silahkan klik pada bagian grafik.
                        </div>
                    <!-- Dropdown untuk filter -->
                    <select class="select2 form-control" id="filter-tag">
                        <option value="bulan">Per Bulan</option>
                        <option value="hari">Per Hari</option>
                        <option value="minggu">Per Minggu</option>
                    </select>
                    <hr>
                    <canvas id="tag" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Top Wartawan
                </div>
                <div class="card-body">
                <h3>GRAFIK DENGAN JUMLAH ARTIKEL TERBANYAK BERDASARKAN DATA ARTIKEL WARTAWAN</h3>
                        <br>
                        <div class="bd-callout bd-callout-info">
                            Berikut ini adalah statistik data poin yang telah dikelompokkan berdasarkan artikel terbanyak pada data wartawan, disajikan dalam bentuk diagram batang.
                            Untuk menampilkan data jumlah artikel berita terbanyak per hari, per minggu, per bulan, silahkan pilih filter yang dibutuhkan. Untuk menampilkan data detailnya, silahkan klik pada bagian grafik.
                        </div>
                    <!-- Dropdown untuk filter -->
                    <select class="select2 form-control" id="filter-wartawan">
                        <option value="bulan">Per Bulan</option>
                        <option value="hari">Per Hari</option>
                        <option value="minggu">Per Minggu</option>
                    </select>
                    <hr>
                    <canvas id="wartawan" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Memperbarui chart setiap kali filter berubah
        $('#filter-kategori').change(updateChartKategori);

        // Fungsi untuk memperbarui chart berdasarkan filter
        function updateChartKategori() {
            const filterValue = $('#filter-kategori').val();
            const ctx = $('#kategori')[0].getContext('2d');
            let url;

            // Tentukan URL berdasarkan nilai filter
            if (filterValue === 'bulan') {
                url = "{{ route('filter.month.kategori') }}";
            } else if (filterValue === 'hari') {
                url = "{{ route('filter.day.kategori') }}";
            } else if (filterValue === 'minggu') {
                url = "{{ route('filter.week.kategori') }}";
            }

            // Lakukan request AJAX
            $.ajax({
                url: url,
                method: "GET",
                success: function(data) {
                    // Buat chart baru dengan data yang diterima
                    const newData = {
                        labels: @json($kategori),
                        datasets: [{
                            label: 'Jumlah Kategori Berita',
                            data: data,
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(250, 150, 64, 0.2)',
                                'rgba(250, 90, 132, 0.2)',
                                'rgba(50, 160, 235, 0.2)',
                                'rgba(250, 200, 86, 0.2)',
                                'rgba(70, 190, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 206, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)',
                                'rgb(255, 159, 64)',
                                'rgb(250, 90, 132)',
                                'rgb(50, 160, 235)',
                                'rgb(250, 200, 86)',
                                'rgb(70, 190, 192)'
                            ],
                        }]
                    };

                    // Hapus chart sebelumnya jika ada
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    // Buat chart baru dengan data yang diterima
                    window.myChart = new Chart(ctx, {
                        type: 'pie',
                        data: newData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        }

        // Memperbarui chart saat halaman dimuat
        updateChartKategori();

        // Memperbarui chart setiap kali filter berubah
        $('#filter-tag').change(updateChartTag);

        // Fungsi untuk memperbarui chart berdasarkan filter
        function updateChartTag() {
            const filterValue = $('#filter-tag').val();
            const ctx2 = $('#tag')[0].getContext('2d');
            let url;

            // Tentukan URL berdasarkan nilai filter
            if (filterValue === 'bulan') {
                url = "{{ route('filter.month.tag') }}";
            } else if (filterValue === 'hari') {
                url = "{{ route('filter.day.tag') }}";
            } else if (filterValue === 'minggu') {
                url = "{{ route('filter.week.tag') }}";
            }

            // Lakukan request AJAX
            $.ajax({
                url: url,
                method: "GET",
                success: function(data) {
                    // Buat chart baru dengan data yang diterima
                    const newData = {
                        labels: @json($tag),
                        datasets: [
                            {
                                data: data,
                                borderWidth: 1,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(250, 150, 64, 0.2)',
                                    'rgba(250, 90, 132, 0.2)',
                                    'rgba(50, 160, 235, 0.2)',
                                    'rgba(250, 200, 86, 0.2)',
                                    'rgba(70, 190, 192, 0.2)',
                                    'rgba(255, 99, 130, 0.2)',
                                    'rgba(54, 162, 230, 0.2)',
                                    'rgba(255, 206, 80, 0.2)',
                                    'rgba(75, 192, 190, 0.2)',
                                    'rgba(153, 102, 250, 0.2)',
                                    'rgba(250, 150, 60, 0.2)',
                                    'rgba(250, 90, 130, 0.2)',
                                    'rgba(50, 160, 230, 0.2)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)',
                                    'rgb(255, 206, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(153, 102, 255)',
                                    'rgb(255, 159, 64)',
                                    'rgb(250, 90, 132)',
                                    'rgb(50, 160, 235)',
                                    'rgb(250, 200, 86)',
                                    'rgb(70, 190, 192)',
                                    'rgb(255, 99, 130)',
                                    'rgb(54, 162, 230)',
                                    'rgb(255, 206, 80)',
                                    'rgb(75, 192, 190)',
                                    'rgb(153, 102, 250)',
                                    'rgb(250, 150, 60)',
                                    'rgb(250, 90, 130)',
                                    'rgb(50, 160, 230)'
                                ],
                            }
                        ]
                    };

                    // Hapus chart sebelumnya jika ada
                    if (window.myChart2) {
                        window.myChart2.destroy();
                    }

                    // Buat chart baru dengan data yang diterima
                    window.myChart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: newData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                callbacks: {
                                label: function(tooltipItem) {
                                        return tooltipItem.yLabel;
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }

        // Memperbarui chart saat halaman dimuat
        updateChartTag();
        
        // Memperbarui chart setiap kali filter berubah
        $('#filter-wartawan').change(updateChartWartawan);

        // Fungsi untuk memperbarui chart berdasarkan filter
        function updateChartWartawan() {
            const filterValue = $('#filter-wartawan').val();
            const ctx3 = $('#wartawan')[0].getContext('2d');
            let url;

            // Tentukan URL berdasarkan nilai filter
            if (filterValue === 'bulan') {
                url = "{{ route('filter.month.wartawan') }}";
            } else if (filterValue === 'hari') {
                url = "{{ route('filter.day.wartawan') }}";
            } else if (filterValue === 'minggu') {
                url = "{{ route('filter.week.wartawan') }}";
            }

            // Lakukan request AJAX
            $.ajax({
                url: url,
                method: "GET",
                success: function(data) {
                    // Buat chart baru dengan data yang diterima
                    const newData = {
                        labels: @json($wartawan),
                        datasets: [
                            {
                                data: data,
                                borderWidth: 1,
                                backgroundColor: 'rgba(235, 64, 52, 0.2 )',
                                borderColor: 'rgb(235, 64, 52)',
                            }
                        ]
                    };

                    // Hapus chart sebelumnya jika ada
                    if (window.myChart3) {
                        window.myChart3.destroy();
                    }

                    // Buat chart baru dengan data yang diterima
                    window.myChart3 = new Chart(ctx3, {
                        type: 'bar',
                        data: newData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                callbacks: {
                                label: function(tooltipItem) {
                                        return tooltipItem.yLabel;
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }

        // Memperbarui chart saat halaman dimuat
        updateChartWartawan();
    });

</script>
@endpush