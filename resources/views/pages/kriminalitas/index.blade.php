@extends('layouts.app', ['title' => 'Data Kriminalitas'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Kriminalitas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Kriminalitas</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Data Kriminalitas</h4>
                                <a href="{{ route('kriminalitas.tambah') }}" class="btn btn-success mt-4 p-2">+ Tambah
                                    Data</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Kecamatan</th>
                                                <th>Tahun</th>
                                                <th>Pencurian</th>
                                                <th>Penipuan</th>
                                                <th>Curanmor</th>
                                                <th>KDRT</th>
                                                <th>Penipuan Online</th>
                                                <th>Jumlah Penduduk</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $i => $item)
                                                <tr>
                                                    <td class="text-center">{{ ++$i }}</td>
                                                    <td>{{ $item->kecamatan->nama }}</td>
                                                    <td>
                                                        <span class="badge badge-primary badge-year">
                                                            {{ $item->tahun }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $item->pencurian }}</td>
                                                    <td>{{ $item->penipuan }}</td>
                                                    <td>{{ $item->curanmor }}</td>
                                                    <td>{{ $item->kdrt }}</td>
                                                    <td>{{ $item->tipu_online }}</td>
                                                    <td>{{ $item->jumlah_penduduk }}</td>
                                                    <td class="text-center">
                                                        <div class="action-buttons">
                                                            <a href="{{ route('kriminalitas.edit', $item->id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                title="Edit"> Edit
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button onclick="deleteData({{ $item->id }}, 'kriminalitas')"
                                                                class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                                title="Hapus"> Hapus
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
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush
@endsection