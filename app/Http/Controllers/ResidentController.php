<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\ResidentModel;
use App\Models\TemporaryResident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ResidentController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Warga',
            'list' => ['Home', 'Resident']
        ];

        $page = (object)[
            'title' => 'Daftar Warga yang terdaftar dalam sistem'
        ];

        return view(
            'resident.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
            ]
        );
    }

    // Ambil data Barang dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        $query = ResidentModel::query();

        // Filter berdasarkan umur
        if ($request->filter_umur == 'balita') {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 5');
        } elseif ($request->filter_umur == 'lansia') {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60');
        }

        // Filter berdasarkan jenis warga
        if ($request->filter_alamat == 'lokal') {
            $query->whereDoesntHave('temporaryResident');
        } elseif ($request->filter_alamat == 'sementara') {
            $query->whereHas('temporaryResident');
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($resident) {
                $btn = '<a href="' . url('/resident/' . $resident->NIK) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                if (Auth::user()->level == 'admin') {
                    $btn .= '<a href="' . url('/resident/' . $resident->NIK . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/resident/' . $resident->NIK) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                }
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Warga',
            'list' => ['Home', 'Warga', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Warga Baru'
        ];

        $family = FamilyModel::all();

        return view('resident.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|string|min:16|unique:warga,NIK',
            'noKK' => 'required',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
            'alamat_asal' => 'required_if:alamat_asal_checkbox,on', // Jika checkbox di-check, alamat_asal harus diisi
            'kepala_keluarga' => [
                function ($attribute, $value, $fail) use ($request) {
                    // Mengecek apakah ada kepala keluarga dengan nomor KK yang sama
                    $count = ResidentModel::where('noKK', $request->noKK)
                        ->where('kepala_keluarga', true)
                        ->count();

                    // Jika ada kepala keluarga lain dengan nomor KK yang sama
                    if ($count > 0 && $value) {
                        $fail('Nomor KK ini sudah memiliki kepala keluarga.');
                    }
                },
            ],
        ]);


        // Fungsi eloquent untuk menambah data
        ResidentModel::create([
            'NIK' => $request->NIK,
            'noKK' => $request->noKK,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'kepala_keluarga' => $request->has('kepala_keluarga') ? 1 : 0,
        ]);

        // Jika checkbox di-check, tambahkan data ke tabel warga sementara
        if ($request->has('alamat_asal_checkbox')) {
            TemporaryResident::create([
                'NIK_warga_sementara' => $request->NIK,
                'alamat_asal' => $request->alamat_asal
            ]);
        }

        return redirect('/resident')->with('success', 'Data warga berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nik)
    {
        // $resident = ResidentModel::where('NIK', $nik)->first();
        $resident = ResidentModel::where('NIK', $nik)
            ->leftJoin('wargasementara', 'warga.NIK', '=', 'wargasementara.NIK_warga_sementara')
            ->first();
        $breadcrumb = (object)[
            'title' => 'Data Warga',
            'list' => ['Home', 'Warga', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Warga'
        ];
        return view('resident.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'resident' => $resident,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nik)
    {
        $resident = ResidentModel::where('NIK', $nik)
            ->leftJoin('wargasementara', 'warga.NIK', '=', 'wargasementara.NIK_warga_sementara')
            ->first();
        $family = FamilyModel::all();
        $anggota = ResidentModel::where('noKK', $resident->noKK)->get();
        $breadcrumb = (object)[
            'title' => 'Edit Warga',
            'list' => ['Home', 'Warga', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Warga'
        ];
        return view('resident.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'resident' => $resident,
            'family' => $family,
            'anggota' => $anggota,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'NIK' => 'required|string|min:16|unique:warga,NIK,' . $id . ',NIK',
            'noKK' => 'required',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
        ]);

        // Update data warga
        $resident = ResidentModel::find($id);
        $resident->update([
            'NIK' => $request->NIK,
            'noKK' => $request->noKK,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'kepala_keluarga' => $request->has('kepala_keluarga') ? true : false
        ]);

        // Set kepala keluarga untuk anggota yang dipilih
        if ($request->has('family_member')) {
            $selectedMember = ResidentModel::where('NIK', $request->family_member)->first();
            if ($selectedMember) {
                $selectedMember->update(['kepala_keluarga' => true]);
            }
        }

        // Cek apakah NIK_warga_sementara tidak ada pada tabel TemporaryResident
        $tempResident = TemporaryResident::where('NIK_warga_sementara', $id)->first();

        // Update data warga sementara jika alamat_asal diisi
        if ($request->has('alamat_asal_checkbox')) {
            if ($tempResident) {
                // Jika data warga sementara sudah ada, update data
                TemporaryResident::where('NIK_warga_sementara', $id)->update([
                    'alamat_asal' => $request->alamat_asal
                ]);
            } else {
                // Jika data warga sementara tidak ada, buat data baru
                TemporaryResident::create([
                    'NIK_warga_sementara' => $request->NIK,
                    'alamat_asal' => $request->alamat_asal,
                ]);
            }
        } else {
            // Jika alamat_asal_checkbox tidak dicentang, hapus data warga sementara jika ada
            if ($tempResident) {
                TemporaryResident::where('NIK_warga_sementara', $id)->delete();
            }
        }

        // Jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/resident')->with('success', 'Data Warga Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = ResidentModel::find($id);
        if (!$check) {
            redirect('/resident')->with('error', 'Data warga tidak ditemukan');
        }

        try {
            ResidentModel::destroy($id);
            return redirect('/resident')->with('success', 'Data warga berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi eror ketika menghapus data, redirect kembali ke halaman dengan membawa pesan eror
            return redirect('/resident')->with('error', 'Data warga gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}