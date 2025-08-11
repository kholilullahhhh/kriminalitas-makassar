@extends('layouts.app', ['title' => 'Uji Method KMeans'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <style>
            .card-criteria {
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                transition: all 0.3s ease;
                border: none;
            }
            .card-criteria:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            }
            .cluster-badge {
                font-size: 0.75rem;
                font-weight: 600;
                padding: 0.35rem 0.75rem;
                border-radius: 50px;
            }
            .cluster-0 { background-color: #fc544b; color: white; }
            .cluster-1 { background-color: #ffa426; color: white; }
            .cluster-2 { background-color: #47c363; color: white; }
            .centroid-list {
                list-style-type: none;
                padding-left: 0;
            }
            .centroid-item {
                padding: 0.75rem 1.25rem;
                margin-bottom: 0.5rem;
                background-color: #f8f9fa;
                border-radius: 8px;
                font-weight: 500;
            }
            .section-title {
                position: relative;
                padding-left: 1rem;
                margin-bottom: 1.5rem;
            }
            .section-title:before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 4px;
                background-color: #6777ef;
                border-radius: 4px;
            }
            .feature-value {
                font-weight: 600;
                color: #6777ef;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-project-diagram text-primary mr-2"></i> Uji Method KMeans</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Analisis</a></div>
                    <div class="breadcrumb-item">Uji KMeans</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Info Box -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card card-criteria bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center border-right">
                                        <h5 class="text-muted">Total Data</h5>
                                        <h3 class="font-weight-bold">{{ $clusters->count() }}</h3>
                                    </div>
                                    <div class="col-md-4 text-center border-right">
                                        <h5 class="text-muted">Jumlah Cluster</h5>
                                        <h3 class="font-weight-bold">{{ count($centroid) }}</h3>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h5 class="text-muted">Iterasi</h5>
                                        <h3 class="font-weight-bold">{{ $iterations ?? 'N/A' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hasil Clustering -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-criteria">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="section">Hasil Clustering</h4>
                                <div>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#methodInfoModal">
                                        <i class="fas fa-info-circle"></i> Panduan
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="cluster-table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Kecamatan</th>
                                                <th>Tahun</th>
                                                <th>Cluster</th>
                                                <th>Kategori</th>
                                                <th>Persentase Kriminal</th>
                                                <th>Jumlah Penduduk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($clusters as $c)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="font-weight-600">{{ $c->dataKriminal->kecamatan->nama }}</div>
                                                        <div class="text-muted small">Kasus: {{ $c->dataKriminal->tipu_online + $c->dataKriminal->pencurian + $c->dataKriminal->penipuan + $c->dataKriminal->curanmor + $c->dataKriminal->kdrt }}</div>
                                                    </td>
                                                    <td>{{ $c->dataKriminal->tahun }}</td>
                                                    <td>{{ $c->cluster }}</td>
                                                    <td>
                                                        <span class="cluster-badge cluster-{{ $c->cluster }}">
                                                            {{ $c->kategori }}
                                                        </span>
                                                    </td>
                                                    <td class="feature-value">{{ number_format($c->nilai, 4) }}%</td>
                                                    <td>{{ number_format($c->dataKriminal->jumlah_penduduk) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Centroid dan Visualisasi -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card card-criteria">
                            <div class="card-header">
                                <h4 class="section">Centroid Akhir</h4>
                            </div>
                            <div class="card-body">
                                <ul class="centroid-list">
                                    @foreach($centroid as $i => $c)
                                        <li class="centroid-item">
                                            <strong>Cluster {{ $i }}</strong> ({{ $clusterNames[$i] ?? 'Unknown' }})
                                            <div class="mt-2">
                                                <span class="feature-value">Persentase: {{ number_format($c['persentase'], 4) }}%</span><br>
                                                <span class="feature-value">Penduduk: {{ number_format($c['jumlah_penduduk']) }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
    </div>

    <!-- Method Info Modal -->
    <div class="modal fade" id="methodInfoModal" tabindex="-1" role="dialog" aria-labelledby="methodInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="methodInfoModalLabel"><i class="fas fa-info-circle mr-2"></i>Panduan Method KMeans</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary">
                        <strong>K-Means Clustering</strong> adalah metode partisi clustering yang membagi data menjadi K cluster dimana setiap data termasuk dalam cluster dengan mean terdekat.
                    </div>
                    
                    <h5>Proses Clustering dengan K-Means:</h5>
                    <ol>
                        <li>Menentukan jumlah cluster (K)</li>
                        <li>Inisialisasi centroid awal (K-Means++)</li>
                        <li>Menghitung jarak setiap data ke centroid</li>
                        <li>Mengelompokkan data ke cluster terdekat</li>
                        <li>Menghitung ulang posisi centroid</li>
                        <li>Iterasi sampai konvergen</li>
                    </ol>

                    <div class="border-top mt-3 pt-3">
                        <h5>Fitur yang Digunakan:</h5>
                        <ul>
                            <li>Persentase Kriminalitas (Total Kasus / Jumlah Penduduk)</li>
                            <li>Jumlah Penduduk</li>
                        </ul>

                        <h5 class="mt-3">Interpretasi Hasil:</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="cluster-badge cluster-0 mr-2"></span>
                                    <span>High Risk Area</span>
                                </div>
                                <p class="text-muted small">Wilayah dengan tingkat kriminalitas tinggi</p>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="cluster-badge cluster-1 mr-2"></span>
                                    <span>Medium Risk Area</span>
                                </div>
                                <p class="text-muted small">Wilayah dengan tingkat kriminalitas sedang</p>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="cluster-badge cluster-2 mr-2"></span>
                                    <span>Low Risk Area</span>
                                </div>
                                <p class="text-muted small">Wilayah dengan tingkat kriminalitas rendah</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
        
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#cluster-table').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                    },
                    "columnDefs": [
                        { "orderable": false, "targets": [0] }
                    ],
                    "order": [[3, 'asc']]
                });

                // Cluster Distribution Chart
                var clusterCounts = {
                    @foreach($clusters->groupBy('cluster') as $cluster => $items)
                        {{ $cluster }}: {{ $items->count() }},
                    @endforeach
                };

                var options = {
                    series: Object.values(clusterCounts),
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    labels: ['High Risk', 'Medium Risk', 'Low Risk'],
                    colors: ['#fc544b', '#ffa426', '#47c363'],
                    legend: {
                        position: 'bottom'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value + ' kecamatan';
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#cluster-chart"), options);
                chart.render();
            });
        </script>
    @endpush
@endsection