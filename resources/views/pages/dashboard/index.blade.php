@extends('layouts.app', ['title' => 'Dashboard Kriminalitas Makassar'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/apexcharts/dist/apexcharts.css') }}">
        <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <style>
            .card-statistic {
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                transition: all 0.3s;
                border: none;
            }
            .card-statistic:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 25px rgba(0,0,0,0.1);
            }
            .statistic-icon {
                font-size: 2rem;
                opacity: 0.8;
            }
            .crime-badge {
                font-size: 0.75rem;
                font-weight: 600;
                padding: 0.35rem 0.6rem;
            }
            .map-container {
                height: 400px;
                border-radius: 12px;
                overflow: hidden;
            }
            .trend-card {
                min-height: 350px;
            }
            .kecamatan-card {
                cursor: pointer;
                transition: all 0.3s;
            }
            .kecamatan-card:hover {
                background-color: #f8f9fa;
            }
            .cluster-badge {
                position: absolute;
                top: -8px;
                right: -8px;
                font-size: 0.65rem;
            }
            .badge-purple {
                background-color: #6c5ce7;
                color: white;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-shield-alt text-primary mr-2"></i> Dashboard Kriminalitas Makassar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Analisis Kriminalitas</div>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Total Kasus</h6>
                                    <h3 class="font-weight-bold">{{ number_format($totalKasus) }}</h3>
                                    <div class="text-small">Tahun {{ date('Y') }}</div>
                                </div>
                                <div class="statistic-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Pencurian</h6>
                                    <h3 class="font-weight-bold">{{ number_format($pencurian) }}</h3>
                                    <div class="text-small">{{ round(($pencurian/$totalKasus)*100, 1) }}% dari total</div>
                                </div>
                                <div class="statistic-icon">
                                    <i class="fas fa-biking"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">KDRT</h6>
                                    <h3 class="font-weight-bold">{{ number_format($kdrt) }}</h3>
                                    <div class="text-small">{{ round(($kdrt/$totalKasus)*100, 1) }}% dari total</div>
                                </div>
                                <div class="statistic-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Kecamatan</h6>
                                    <h3 class="font-weight-bold">{{ $totalKecamatan }}</h3>
                                    <div class="text-small">Wilayah Pemantauan</div>
                                </div>
                                <div class="statistic-icon">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peta dan Trend -->
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-map-marker-alt mr-2"></i> Peta Sebaran Kriminalitas Makassar</h4>
                        </div>
                        <div class="card-body">
                            <div class="map-container" id="crime-map">
                                <!-- Peta akan di-render oleh JavaScript -->
                                <div class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Memuat peta...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card trend-card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-line mr-2"></i> Trend Kriminalitas 3 Tahun Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <div id="crime-trend-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analisis Cluster -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-pie mr-2"></i> Analisis Cluster Kriminalitas</h4>
                            <div class="card-header-action">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#clusterInfoModal">
                                    <i class="fas fa-info-circle"></i> Penjelasan Cluster
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body text-center">
                                            <h2 class="text-primary">{{ $clusterHigh }}</h2>
                                            <div class="text-primary font-weight-bold">High Risk Area</div>
                                            <div class="text-muted small">Zona Merah</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body text-center">
                                            <h2 class="text-warning">{{ $clusterMedium }}</h2>
                                            <div class="text-warning font-weight-bold">Medium Risk Area</div>
                                            <div class="text-muted small">Zona Kuning</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body text-center">
                                            <h2 class="text-success">{{ $clusterLow }}</h2>
                                            <div class="text-success font-weight-bold">Low Risk Area</div>
                                            <div class="text-muted small">Zona Hijau</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="cluster-chart" style="min-height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Kriminalitas per Kecamatan -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4><i class="fas fa-table mr-2"></i> Data Kriminalitas per Kecamatan</h4>
                            <div>
                                <button class="btn btn-sm btn-outline-primary mr-2" id="export-excel">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                                <a href="{{ route('kriminalitas.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="crime-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kecamatan</th>
                                            <th>Tahun</th>
                                            <th>Pencurian</th>
                                            <th>Penipuan</th>
                                            <th>Curanmor</th>
                                            <th>KDRT</th>
                                            <th>Online</th>
                                            <th>Total</th>
                                            <th>Cluster</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="font-weight-600">{{ $item->kecamatan->nama }}</div>
                                                    <div class="text-muted small">Penduduk: {{ number_format($item->jumlah_penduduk) }}</div>
                                                </td>
                                                <td>{{ $item->tahun }}</td>
                                                <td>
                                                    <span class="crime-badge badge badge-danger">{{ number_format($item->pencurian) }}</span>
                                                </td>
                                                <td>
                                                    <span class="crime-badge badge badge-warning">{{ number_format($item->penipuan) }}</span>
                                                </td>
                                                <td>
                                                    <span class="crime-badge badge badge-info">{{ number_format($item->curanmor) }}</span>
                                                </td>
                                                <td>
                                                    <span class="crime-badge badge badge-purple">{{ number_format($item->kdrt) }}</span>
                                                </td>
                                                <td>
                                                    <span class="crime-badge badge badge-secondary">{{ number_format($item->tipu_online) }}</span>
                                                </td>
                                                <td class="font-weight-bold">{{ number_format($item->total_kasus) }}</td>
                                                <td>
                                                    @if($item->cluster)
                                                        @if($item->cluster->kategori == 'Tinggi')
                                                            <span class="badge badge-danger">{{ $item->cluster->kategori }}</span>
                                                        @elseif($item->cluster->kategori == 'Sedang')
                                                            <span class="badge badge-warning">{{ $item->cluster->kategori }}</span>
                                                        @else
                                                            <span class="badge badge-success">{{ $item->cluster->kategori }}</span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-light">Belum Dianalisis</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('kriminalitas.edit', $item->id) }}" 
                                                           class="btn btn-sm btn-warning" 
                                                           data-toggle="tooltip" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button onclick="confirmDelete({{ $item->id }}, 'kriminalitas')"
                                                                class="btn btn-sm btn-danger"
                                                                data-toggle="tooltip"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Cluster Info Modal -->
    <div class="modal fade" id="clusterInfoModal" tabindex="-1" role="dialog" aria-labelledby="clusterInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clusterInfoModalLabel"><i class="fas fa-info-circle mr-2"></i>Penjelasan Analisis Cluster</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-danger text-white">High Risk Area</div>
                                <div class="card-body">
                                    <p>Wilayah dengan tingkat kriminalitas tinggi yang membutuhkan penanganan khusus dan pengawasan ekstra.</p>
                                    <ul>
                                        <li>Frekuensi kejahatan tinggi</li>
                                        <li>Berbagai jenis kejahatan</li>
                                        <li>Prioritas penanganan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning mb-3">
                                <div class="card-header bg-warning text-white">Medium Risk Area</div>
                                <div class="card-body">
                                    <p>Wilayah dengan tingkat kriminalitas sedang yang membutuhkan peningkatan pengawasan rutin.</p>
                                    <ul>
                                        <li>Frekuensi kejahatan sedang</li>
                                        <li>Beberapa jenis kejahatan</li>
                                        <li>Pengawasan rutin</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success mb-3">
                                <div class="card-header bg-success text-white">Low Risk Area</div>
                                <div class="card-body">
                                    <p>Wilayah dengan tingkat kriminalitas rendah yang perlu dijaga dengan patroli preventif.</p>
                                    <ul>
                                        <li>Frekuensi kejahatan rendah</li>
                                        <li>Minimal jenis kejahatan</li>
                                        <li>Patroli preventif</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Metode Analisis:</strong> Clustering menggunakan algoritma K-Means berdasarkan frekuensi dan jenis kejahatan per kapita.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('library/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.indonesia.js') }}"></script>
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#crime-table').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                    },
                    "columnDefs": [
                        { "orderable": false, "targets": [0, 10] }
                    ],
                    "order": [[8, 'desc']]
                });

                // Crime Trend Chart
                var trendOptions = {
                    series: [{
                        name: 'Total Kasus',
                        data: @json($trendData['total'])
                    }, {
                        name: 'Pencurian',
                        data: @json($trendData['pencurian'])
                    }, {
                        name: 'KDRT',
                        data: @json($trendData['kdrt'])
                    }],
                    chart: {
                        height: 300,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [3, 3, 3]
                    },
                    colors: ['#6777ef', '#fc544b', '#ffa426'],
                    xaxis: {
                        categories: @json($trendData['years']),
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " kasus"
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                };
                var trendChart = new ApexCharts(document.querySelector("#crime-trend-chart"), trendOptions);
                trendChart.render();

                // Cluster Chart
                var clusterOptions = {
                    series: @json($clusterSeries),
                    chart: {
                        type: 'radar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#fc544b', '#ffa426', '#47c363'],
                    xaxis: {
                        categories: ['Pencurian', 'Penipuan', 'Curanmor', 'KDRT', 'Online']
                    },
                    yaxis: {
                        show: false
                    },
                    markers: {
                        size: 4,
                        hover: {
                            size: 6
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " kasus per 10.000 penduduk";
                            }
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                };
                var clusterChart = new ApexCharts(document.querySelector("#cluster-chart"), clusterOptions);
                clusterChart.render();

                // Initialize Map
                $('#crime-map').vectorMap({
                    map: 'indonesia_id',
                    backgroundColor: 'transparent',
                    regionStyle: {
                        initial: {
                            fill: '#e3eaef',
                            stroke: '#ffffff',
                            "stroke-width": 1,
                            "stroke-opacity": 1
                        },
                        hover: {
                            fill: '#6777ef',
                            cursor: 'pointer'
                        }
                    },
                    series: {
                        regions: [{
                            values: @json($mapData),
                            scale: ['#e3eaef', '#6777ef'],
                            normalizeFunction: 'polynomial'
                        }]
                    },
                    onRegionTipShow: function(event, label, code) {
                        var value = $('.jvectormap-tip').html();
                        if (value in @json($kecamatanData)) {
                            var data = @json($kecamatanData)[value];
                            label.html(
                                '<strong>' + value + '</strong><br/>' +
                                'Total Kasus: ' + data.total + '<br/>' +
                                'Pencurian: ' + data.pencurian + '<br/>' +
                                'KDRT: ' + data.kdrt + '<br/>' +
                                'Cluster: ' + data.cluster
                            );
                        } else {
                            label.html('<strong>' + value + '</strong><br/>Data tidak tersedia');
                        }
                    }
                });

                // Export Excel
                $('#export-excel').click(function() {
                    window.location.href = "{{ route('kriminalitas.export') }}";
                });

                // Tooltip
                $('[data-toggle="tooltip"]').tooltip();
            });

            function confirmDelete(id, route) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/${route}/${id}`,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection