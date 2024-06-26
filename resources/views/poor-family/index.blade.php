@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-dark-blue">
            <div class="card-tools float-left">
                <a class="btn btn-sm bg-primary text-white mt-2" href="{{ url('poor-family/calculate') }}">Hitung</a>
                <a class="btn btn-sm bg-primary text-white mt-2" href="{{ url('poor-family/criteria') }}">Criteria</a>
            </div>
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-primary text-white" href="{{ url('submission-add') }}">Daftar Pengajuan</a>
                @if (Auth::user()->level == 'admin')
                    <a class="btn btn-sm bg-primary text-white" href="{{ url('poor-family/create') }}">
                        <i class="fas fa-fw fa-plus"></i> Tambah
                    </a>
                @endif
                <!-- Form Import -->
                <form action="{{ url('poor-family/import') }}" method="POST" enctype="multipart/form-data"
                    style="display: inline;">
                    @csrf
                    <input type="file" name="file" class="d-none" id="importFile" onchange="this.form.submit()">
                    <label class="btn btn-sm bg-primary text-white" for="importFile" style="margin-top: 0.5rem;">
                        <i class="fas fa-regular fa-file-excel"></i> Import
                    </label>

                </form>
                <a class="btn btn-sm bg-primary text-white " href="{{ url('poor-family/export') }}">
                    <i class="fas fa-regular fa-file-excel"></i> Export
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive">
            <table id="poorFamilyTable" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Jumlah Anggota</th>
                        <th style="width: 14%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rankedFamilies as $index => $family)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $family['noKK'] }}</td>
                            <td>{{ $family['nama'] }}</td>
                            <td>{{ $family['jumlah_anggota'] }}</td>
                            <td class="text-center">
                                <a href="{{ url('/poor-family/' . $family['noKK']) }}" class="btn btn-info btn-sm"><i
                                        class="fas fa-eye"></i></a>
                                @if (Auth::user()->level == 'admin')
                                    <a href="{{ url('/poor-family/' . $family['noKK'] . '/edit') }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form class="d-inline-block" method="POST"
                                        action="{{ url('/poor-family/' . $family['noKK']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin menghapus data ini?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endpush
@push('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#poorFamilyTable').DataTable();
        });
    </script>
@endpush
