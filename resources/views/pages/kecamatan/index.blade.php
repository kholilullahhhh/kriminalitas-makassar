@extends('layouts.app', ['title' => 'Data Kecamatan Gowa'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-icons/font/bootstrap-icons.css') }}">
        <style>
            .card-header {
                padding: 1.25rem 1.5rem;
                border-bottom: 1px solid #f0f0f0;
            }
            .table th {
                background-color: #f9f9f9;
                white-space: nowrap;
            }
            .kecamatan-name {
                font-weight: 600;
                color: #34395e;
            }
            .action-buttons .btn {
                padding: 0.35rem 0.6rem;
                font-size: 0.875rem;
            }
            .section-header-breadcrumb .breadcrumb-item {
                font-size: 0.85rem;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="bi bi-map-fill text-primary mr-2"></i> Data Kecamatan Makassar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Wilayah</div>
                    <div class="breadcrumb-item">Kecamatan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Daftar Kecamatan</h4>
                                @if(auth()->user()->can('create-kecamatan'))
                                <a href="{{ route('kecamatan.create') }}" class="btn btn-primary btn-icon">
                                    <i class="bi bi-plus-lg"></i> Tambah Kecamatan
                                </a>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="table-1">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th>Nama Kecamatan</th>
                                                <th class="text-center" width="15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                    <td class="align-middle">
                                                        <span class="kecamatan-name">{{ $item->nama }}</span>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <div class="action-buttons d-flex justify-content-center">
                                                            @can('edit-kecamatan')
                                                            <a href="{{ route('kecamatan.edit', $item->id) }}" 
                                                               class="btn btn-sm btn-warning mr-2"
                                                               data-toggle="tooltip" title="Edit">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            @endcan
                                                            
                                                            @can('delete-kecamatan')
                                                            <form action="{{ route('kecamatan.destroy', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-sm btn-danger delete-confirm"
                                                                        data-toggle="tooltip" 
                                                                        title="Hapus">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                            @endcan
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
        <script src="{{ asset('library/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#table-1').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                    },
                    "columnDefs": [
                        { "orderable": false, "targets": [0, 2] }
                    ],
                    "order": [[1, 'asc']]
                });

                // Enable tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // Delete confirmation
                $('.delete-confirm').on('click', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data kecamatan akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection 