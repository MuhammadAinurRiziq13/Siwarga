@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-dark-blue">
            <div class="card-tools float-right">
                <a class="btn btn-sm text-white bg-primary" href="{{ url('submission-changes') }}">Daftar
                    Pengajuan</a>
                @if (Auth::user()->level == 'admin')
                    <a class="btn btn-sm text-white bg-primary" href="{{ url('resident/create') }}"><i
                            class="fas fa-fw fa-plus"></i> Tambah</a>
                @endif
                <!-- Form Import -->
                <form action="{{ url('resident/import') }}" method="POST" enctype="multipart/form-data"
                    style="display: inline;">
                    @csrf
                    <input type="file" name="file" class="d-none" id="importFile" onchange="this.form.submit()">
                    <label class="btn btn-sm text-white bg-primary" for="importFile" style="margin-top: 0.5rem;">
                        <i class="fas fa-regular fa-file-excel"></i> Import
                    </label>
                </form>
                <a class="btn btn-sm text-white bg-primary" href="{{ url('resident/export') }}">
                    <i class="fas fa-regular fa-file-excel"></i> Export
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="" class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="filter_alamat" id="filter_alamat" class="form-control">
                                <option value="">- Semua -</option>
                                <option value="lokal">Warga Lokal</option>
                                <option value="sementara">Warga Sementara</option>
                            </select>
                            <small class="form-text text-muted">Alamat Asal</small>
                        </div>
                        <div class="col-3">
                            <select name="filter_umur" id="filter_umur" class="form-control">
                                <option value="">- Semua -</option>
                                <option value="balita">Balita</option>
                                <option value="lansia">Lansia</option>
                            </select>
                            <small class="form-text text-muted">Rentang Umur</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_resident">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th style="width: 14%">Aksi</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataResident = $('#table_resident').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('resident/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(data) {
                        data.filter_umur = $('#filter_umur').val();
                        data.filter_alamat = $('#filter_alamat').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'NIK',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'nama',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'tempat_lahir',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'tanggal_lahir',
                        className: '',
                        orderable: true,
                        searchable: false,
                        render: data => {
                            const date = new Date(data);
                            return `${("0" + date.getDate()).slice(-2)}-${("0" + (date.getMonth() + 1)).slice(-2)}-${date.getFullYear()}`;
                        }
                    },
                    {
                        data: 'jenis_kelamin',
                        className: '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aksi',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#filter_umur, #filter_alamat').on('change', function() {
                dataResident.ajax.reload();
            });
        });
    </script>
@endpush
