@extends('layouts.app', ['title' => 'Edit Data Kriminalitas'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <style>
            .form-section {
                margin-bottom: 2rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid #eee;
            }

            .form-section-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: #34395e;
                margin-bottom: 1.5rem;
            }

            .form-group label {
                font-weight: 500;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data Kriminalitas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Kriminalitas</div>
                    <div class="breadcrumb-item">Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-edit"></i> Form Edit Data Kriminalitas</h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('kriminalitas.update', $data->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" class="id" value="{{ $data->id }}">

                                    <!-- Section 1: Basic Information -->
                                    <div class="form-section">
                                        <div class="form-section-title">
                                            <i class="fas fa-info-circle"></i> Informasi Dasar
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kecamatan_id">Kecamatan</label>
                                                    <select name="kecamatan_id" id="kecamatan_id"
                                                        class="form-control select2" required>
                                                        <option value="">Pilih Kecamatan</option>
                                                        @foreach($kecamatans as $kecamatan)
                                                            <option value="{{ $kecamatan->id }}" {{ $data->kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                                                {{ $kecamatan->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tahun">Tahun</label>
                                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                                        required min="2000" max="{{ date('Y') + 1 }}"
                                                        value="{{ $data->tahun }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 2: Crime Cases -->
                                    <div class="form-section">
                                        <div class="form-section-title">
                                            <i class="fas fa-exclamation-triangle"></i> Data Kasus Kriminal
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tipu_online">Penipuan Online</label>
                                                    <input type="number" name="tipu_online" id="tipu_online"
                                                        class="form-control" required min="0"
                                                        value="{{ $data->tipu_online }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="pencurian">Pencurian</label>
                                                    <input type="number" name="pencurian" id="pencurian"
                                                        class="form-control" required min="0"
                                                        value="{{ $data->pencurian }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="penipuan">Penipuan</label>
                                                    <input type="number" name="penipuan" id="penipuan" class="form-control"
                                                        required min="0" value="{{ $data->penipuan }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="curanmor">Pencurian Motor</label>
                                                    <input type="number" name="curanmor" id="curanmor" class="form-control"
                                                        required min="0" value="{{ $data->curanmor }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="kdrt">KDRT</label>
                                                    <input type="number" name="kdrt" id="kdrt" class="form-control" required
                                                        min="0" value="{{ $data->kdrt }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 3: Population -->
                                    <div class="form-section">
                                        <div class="form-section-title">
                                            <i class="fas fa-users"></i> Data Demografi
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jumlah_penduduk">Jumlah Penduduk</label>
                                                    <input type="number" name="jumlah_penduduk" id="jumlah_penduduk"
                                                        class="form-control" required min="0"
                                                        value="{{ $data->jumlah_penduduk }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="row mt-4">
                                        <div class="col-md-12 text-right">
                                            <button type="reset" class="btn btn-secondary mr-2">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
                                            <a href="{{ route('kriminalitas.index') }}" class="btn btn-light ml-2">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
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
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                // Initialize select2
                $('.select2').select2({
                    placeholder: "Pilih Kecamatan",
                    allowClear: true
                });
            });
        </script>
    @endpush
@endsection