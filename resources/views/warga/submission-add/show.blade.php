@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($add)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No KK</th>
                        <td>{{ $add->noKK }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pemohon</th>
                        <td>{{ $nama->kepala_keluarga }}</td>
                    </tr>
                    {{-- @foreach ($criteria as $c)
                        @if (isset($add->{$c->kode}))
                            @if ($c->nama == 'Jumlah Tanggungan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $add->{$c->kode} }} Orang</td>
                                </tr>
                            @elseif ($c->nama == 'Pendapatan' || $c->nama == 'Aset Kendaraan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>Rp{{ $add->{$c->kode} }}</td>
                                </tr>
                            @elseif ($c->nama == 'Luas tanah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $add->{$c->kode} }} m<sup>2</sup></td>
                                </tr>
                            @elseif ($c->nama == 'Kondisi Rumah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $add->{$c->kode} }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach --}}
                    @foreach ($criteria as $c)
                        @if (isset($add->{$c->kode}))
                            @if ($c->nama == 'Jumlah Tanggungan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $add->{$c->kode} }} orang</td>
                                </tr>
                            @elseif ($c->nama == 'Pendapatan' || $c->nama == 'Aset Kendaraan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>Rp{{ $add->{$c->kode} }}</td>
                                </tr>
                            @elseif ($c->nama == 'Luas Tanah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $add->{$c->kode} }} m<sup>2</sup></td>
                                </tr>
                            @elseif ($c->nama == 'Kondisi Rumah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    @if ($add->{$c->kode} == 1)
                                        <td>Rumah Kontrak</td>
                                    @elseif ($add->{$c->kode} == 2)
                                        <td>Buruk Layak</td>
                                    @elseif ($add->{$c->kode} == 3)
                                        <td>Kurang Layak</td>
                                    @elseif ($add->{$c->kode} == 4)
                                        <td>Cukup Layak</td>
                                    @elseif ($add->{$c->kode} == 5)
                                        <td>Layak</td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $add->{$c->kode} }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    <tr>
                        <th>No HP</th>
                        <td>{{ $add->no_hp }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Bukti Foto</th>
                        <td>
                            @foreach ($bukti as $foto)
                                <img src="{{ asset('storage/' . $foto->nama_bukti) }}" style="max-width:400px; max-height:400px"
                                    class="rounded mb-2">
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('submission-prasejahtera/' . Auth::user()->username) }}"
                class="btn btn-sm btn-secondary m-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
