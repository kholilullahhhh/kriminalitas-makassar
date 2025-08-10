@extends('layouts.app', ['title' => 'Tambah Data Kriminalitas'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Kriminalitas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Kriminalitas</div>
                    <div class="breadcrumb-item">Tambah Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Data Kriminalitas</h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('kriminalitas.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kecamatan</label>
                                                <select name="kecamatan_id" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    @foreach($kecamatans as $kecamatan)
                                                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tahun</label>
                                                <input type="number" name="tahun" class="form-control" required min="2000" max="{{ date('Y') + 1 }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Kasus Narkotika</label>
                                                <input type="number" name="narkotika" class="form-control" required min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Kasus Pencurian</label>
                                                <input type="number" name="pencurian" class="form-control" required min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Kasus Penipuan</label>
                                                <input type="number" name="penipuan" class="form-control" required min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Kasus Pembunuhan</label>
                                                <input type="number" name="pembunuhan" class="form-control" required min="0">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jumlah Penduduk</label>
                                                <input type="number" name="jumlah_penduduk" class="form-control" required min="0">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                                            <a href="{{ route('kriminalitas.index') }}" class="btn btn-secondary">Kembali</a>
                                        </div>
                                    </div>
                                </form>
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