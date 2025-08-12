@extends('layouts.app', ['title' => 'Uji Method KMeans'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <style>
            .card-criteria {
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                border: none;
            }

            .card-criteria:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
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

            .year-tab-content {
                padding: 20px;
                background: white;
                border: 1px solid #dee2e6;
                border-top: none;
                border-radius: 0 0 8px 8px;
            }

            .nav-year-tabs .nav-link {
                font-weight: 600;
                color: #6c757d;
                border: 1px solid transparent;
                border-bottom: none;
                margin-right: 5px;
            }

            .nav-year-tabs .nav-link.active {
                color: #6777ef;
                background: white;
                border-color: #dee2e6 #dee2e6 white;
                border-radius: 8px 8px 0 0;
            }

            .chart-container {
                height: 300px;
                position: relative;
            }
            
            .info-box {
                border-left: 4px solid #6777ef;
            }
            
            .crime-type-badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
                margin-right: 0.3rem;
                border-radius: 4px;
                background-color: #e9ecef;
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
                <!-- Yearly Tabs -->
                <div class="row mb-4">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-year-tabs" id="yearTabs" role="tablist">
                            @foreach($years as $year)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                       id="year-{{ $year }}-tab"
                                       data-toggle="tab" 
                                       href="#year-{{ $year }}" 
                                       role="tab" 
                                       aria-controls="year-{{ $year }}"
                                       aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        Tahun {{ $year }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content year-tab-content" id="yearTabsContent">
                            @foreach($years as $year)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                     id="year-{{ $year }}"
                                     role="tabpanel" 
                                     aria-labelledby="year-{{ $year }}-tab">

                                    <!-- Info Box for this year -->
                                    <div class="row mb-4">
                                        @php
                                            $yearData = $clusters->where('tahun', $year);
                                            $totalCases = $yearData->sum('total_kasus');
                                        @endphp
                                        
                                        <div class="col-md-3">
                                            <div class="card card-criteria info-box">
                                                <div class="card-body py-3">
                                                    <div class="text-center">
                                                        <h5 class="text-muted mb-2">Total Data</h5>
                                                        <h3 class="font-weight-bold text-primary">
                                                            {{ $yearData->count() }}
                                                        </h3>
                                                        <small class="text-muted">Kecamatan</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="card card-criteria info-box">
                                                <div class="card-body py-3">
                                                    <div class="text-center">
                                                        <h5 class="text-muted mb-2">Total Kasus</h5>
                                                        <h3 class="font-weight-bold text-primary">
                                                            {{ $totalCases }}
                                                        </h3>
                                                        <small class="text-muted">Kejadian kriminal</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="card card-criteria info-box">
                                                <div class="card-body py-3">
                                                    <div class="text-center">
                                                        <h5 class="text-muted mb-2">Iterasi</h5>
                                                        <h3 class="font-weight-bold text-primary">
                                                            {{ $iterationsByYear[$year] ?? 'N/A' }}
                                                        </h3>
                                                        <small class="text-muted">Proses clustering</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="card card-criteria info-box">
                                                <div class="card-body py-3">
                                                    <div class="text-center">
                                                        <h5 class="text-muted mb-2">Rata-rata Kasus</h5>
                                                        <h3 class="font-weight-bold text-primary">
                                                            {{ number_format($totalCases / max(1, $yearData->count()), 2) }}
                                                        </h3>
                                                        <small class="text-muted">Per kecamatan</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Hasil Clustering for this year -->
                                        <div class="col-md-8">
                                            <div class="card card-criteria">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h4 class="section">Hasil Clustering Tahun {{ $year }}</h4>
                                                    <div>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#methodInfoModal">
                                                            <i class="fas fa-info-circle"></i> Panduan
                                                        </button>
                                                        <!-- <button class="btn btn-sm btn-success" onclick="exportToExcel({{ $year }})">
                                                            <i class="fas fa-file-excel"></i> Export
                                                        </button> -->
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-hover"
                                                            id="cluster-table-{{ $year }}">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Kecamatan</th>
                                                                    <th>Cluster</th>
                                                                    <th>Kategori</th>
                                                                    <th>Persentase</th>
                                                                    <th>Total Kasus</th>
                                                                    <th>jumlah Penduduk</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($yearData as $c)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>
                                                                            <div class="font-weight-600">
                                                                                {{ $c->dataKriminal->kecamatan->nama ?? 'N/A' }}
                                                                            </div>
                                                                        </td>
                                                                        <td>{{ $c->cluster }}</td>
                                                                        <td>
                                                                            <span class="cluster-badge cluster-{{ $c->cluster }}">
                                                                                {{ $c->kategori }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="feature-value">{{ number_format($c->nilai, 4) }}%</td>
                                                                        <td>{{ $c->total_kasus }}</td>
                                                                                                                                                                    <td>{{ number_format($c->dataKriminal->jumlah_penduduk) }}
                                                                                            </td>

                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Centroid and Chart for this year -->
                                        <div class="col-md-4">
                                            <div class="card card-criteria mb-4">
                                                <div class="card-header">
                                                    <h4 class="section">Centroid Akhir</h4>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="centroid-list">
                                                        @foreach($centroids[$year] as $i => $c)
                                                            <li class="centroid-item">
                                                                <strong>Cluster {{ $i }}</strong> ({{ $clusterNames[$i] ?? 'Unknown' }})
                                                                <div class="mt-2">
                                                                    <span class="feature-value">Persentase: {{ number_format($c['persentase'], 4) }}%</span><br>
                                                                    <span class="feature-value">Penduduk: {{ number_format($c['jumlah_penduduk']) }}</span>
                                                                    @if($i == 0)
                                                                        <div class="mt-2">
                                                                            <small class="text-muted">Jenis Kriminal Dominan:</small><br>
                                                                            <strong>
                                                                                @switch($topCrimesByYear[$year]['top_crime'])
                                                                                    @case('tipu_online') Penipuan Online @break
                                                                                    @case('pencurian') Pencurian @break
                                                                                    @case('penipuan') Penipuan @break
                                                                                    @case('curanmor') Pencurian Kendaraan @break
                                                                                    @case('kdrt') KDRT @break
                                                                                @endswitch
                                                                            </strong>
                                                                            <small>({{ $topCrimesByYear[$year]['top_value'] }} kasus)</small>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card card-criteria">
                                                <div class="card-header">
                                                    <h4 class="section">Distribusi Kriminalitas</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div id="crime-chart-{{ $year }}" class="chart-container"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Method Info Modal -->
    <div class="modal fade" id="methodInfoModal" tabindex="-1" role="dialog" aria-labelledby="methodInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="methodInfoModalLabel">
                        <i class="fas fa-info-circle mr-2"></i>Panduan Method KMeans
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary">
                        <strong>K-Means Clustering</strong> adalah metode partisi clustering yang membagi data menjadi K
                        cluster dimana setiap data termasuk dalam cluster dengan mean terdekat.
                    </div>

                    <h5>Proses Clustering dengan K-Means:</h5>
                    <ol>
                        <li>Menentukan jumlah cluster (K=3)</li>
                        <li>Inisialisasi centroid awal menggunakan K-Means++</li>
                        <li>Menghitung jarak Euclidean setiap data ke centroid</li>
                        <li>Mengelompokkan data ke cluster terdekat</li>
                        <li>Menghitung ulang posisi centroid</li>
                        <li>Iterasi sampai konvergen (maks 100 iterasi)</li>
                    </ol>

                    <div class="border-top mt-3 pt-3">
                        <h5>Fitur yang Digunakan:</h5>
                        <ul>
                            <li><strong>Persentase Kriminalitas:</strong> (Total Kasus / Jumlah Penduduk) × 100</li>
                            <li><strong>Jumlah Penduduk:</strong> Untuk normalisasi data</li>
                        </ul>

                        <h5 class="mt-3">Interpretasi Hasil:</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="cluster-badge cluster-0 mr-2"></span>
                                    <span>High Risk Area</span>
                                </div>
                                <p class="text-muted small">Wilayah dengan tingkat kriminalitas tinggi (persentase >
                                    {{ number_format($centroids[$years->first()][0]['persentase'] ?? 0, 2) }}%)
                                </p>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="cluster-badge cluster-1 mr-2"></span>
                                    <span>Medium Risk Area</span>
                                </div>
                                <p class="text-muted small">Wilayah dengan tingkat kriminalitas sedang (persentase
                                    {{ number_format($centroids[$years->first()][1]['persentase'] ?? 0, 2) }}%-{{ number_format($centroids[$years->first()][0]['persentase'] ?? 0, 2) }}%)
                                </p>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="cluster-badge cluster-2 mr-2"></span>
                                    <span>Low Risk Area</span>
                                </div>
                                <p class="text-muted small">Wilayah dengan tingkat kriminalitas rendah (persentase < {{ number_format($centroids[$years->first()][1]['persentase'] ?? 0, 2) }}%)</p>
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
    
    <!-- Detail Kriminal Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Kriminalitas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Content will be loaded via AJAX -->
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
        <script src="{{ asset('library/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('library/xlsx/xlsx.full.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                // Initialize DataTables for each year
                @foreach($years as $year)
                    $('#cluster-table-{{ $year }}').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                        },
                        "columnDefs": [
                            { "orderable": false, "targets": [0, 6] }
                        ],
                        "order": [[3, 'asc']],
                        "dom": '<"top"f>rt<"bottom"lip><"clear">',
                        "pageLength": 10
                    });
                @endforeach

                // Initialize crime charts for each year
                @foreach($years as $year)
                    var crimeData{{ $year }} = {
                        labels: ['Penipuan Online', 'Pencurian', 'Penipuan', 'Curanmor', 'KDRT'],
                        series: [
                            {{ $topCrimesByYear[$year]['all_crimes']['tipu_online'] }},
                            {{ $topCrimesByYear[$year]['all_crimes']['pencurian'] }},
                            {{ $topCrimesByYear[$year]['all_crimes']['penipuan'] }},
                            {{ $topCrimesByYear[$year]['all_crimes']['curanmor'] }},
                            {{ $topCrimesByYear[$year]['all_crimes']['kdrt'] }}
                        ]
                    };

                    var crimeOptions{{ $year }} = {
                        chart: {
                            type: 'bar',
                            height: 300,
                            toolbar: { show: false }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                borderRadius: 4,
                                dataLabels: {
                                    position: 'top'
                                }
                            }
                        },
                        series: [{
                            name: 'Jumlah Kasus',
                            data: crimeData{{ $year }}.series
                        }],
                        xaxis: {
                            categories: crimeData{{ $year }}.labels
                        },
                        colors: ['#6777ef'],
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return val;
                            },
                            offsetX: -10,
                            style: {
                                fontSize: '12px',
                                colors: ['#000']
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " kasus";
                                }
                            }
                        }
                    };

                    var crimeChart{{ $year }} = new ApexCharts(
                        document.querySelector("#crime-chart-{{ $year }}"), 
                        crimeOptions{{ $year }}
                    );
                    crimeChart{{ $year }}.render();
                @endforeach
            });
            
            function showDetailModal(id) {
                $.get('/data-kriminal/' + id + '/detail', function(data) {
                    $('#detailModalBody').html(data);
                    $('#detailModal').modal('show');
                });
            }
            
            function exportToExcel(year) {
                // Get the table data
                var table = $('#cluster-table-' + year).DataTable();
                var data = table.rows().data().toArray();
                
                // Prepare the worksheet
                var wsData = [
                    ['No', 'Kecamatan', 'Cluster', 'Kategori', 'Persentase', 'Total Kasus']
                ];
                
                data.forEach(function(row, index) {
                    wsData.push([
                        index + 1,
                        row[1],
                        row[2],
                        row[3],
                        row[4],
                        row[5]
                    ]);
                });
                
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.aoa_to_sheet(wsData);
                XLSX.utils.book_append_sheet(wb, ws, "Cluster_" + year);
                
                // Export the file
                XLSX.writeFile(wb, 'hasil_clustering_' + year + '.xlsx');
            }
        </script>
    @endpush
@endsection