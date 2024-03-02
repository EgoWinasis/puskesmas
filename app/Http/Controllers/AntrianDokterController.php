<?php

namespace App\Http\Controllers;

use App\Models\ModelPelayanan;
use App\Models\ModelPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AntrianDokterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'apoteker') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        $antrian = DB::table('pelayanan')
        ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
        ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
        ->leftJoin('pemeriksaan', function ($join) {
            $join->on('pelayanan.id', '=', 'pemeriksaan.pelayanan_id')
                ->whereNull('pemeriksaan.deleted_at'); // Join condition and filter for pemeriksaan record not deleted
        })
        ->whereNull('pelayanan.deleted_at')
        ->whereNull('pasien.deleted_at')
        ->whereDate('pelayanan.created_at', now()->toDateString()) // Filter for today's date in the 'pelayanan' table
        ->where('pelayanan.tujuan', Auth::user()->jabatan)
        ->whereNull('pemeriksaan.pelayanan_id') // Exclude rows where a corresponding record exists in pemeriksaan
        ->orderBy('pelayanan.created_at', 'asc')
        ->get();


        return view('antrian_dokter.antrian_dokter_view')->with(compact('antrian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->input('id');

        try {
            $pelayanan = ModelPelayanan::findOrFail($id);

            $pemeriksaan = new ModelPemeriksaan();
            $pemeriksaan->pasien_id = $pelayanan->pasien_id;
            $pemeriksaan->pelayanan_id = $pelayanan->id;
            $pemeriksaan->tujuan = $pelayanan->tujuan;
            $pemeriksaan->keluhan = $pelayanan->keluhan;
            $pemeriksaan->catatan = $pelayanan->catatan;
            $pemeriksaan->diagnosa = ''; // Assuming 'diagnosa' is nullable
            $pemeriksaan->obat = ''; // Assuming 'obat' is nullable
            $pemeriksaan->save();

            return response()->json(['message' => 'Berhasil Memindahkan Data Pasien Ke Proses Pemeriksaan']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pasien = DB::table('pelayanan')
            ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.bpjs', 'pasien.tgl_lahir', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
            ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
            ->whereNull('pelayanan.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('pelayanan.created_at', now()->toDateString()) // Filter for today's date in the 'pelayanan' table
            ->orderBy('pelayanan.created_at', 'asc')
            ->get();

        $pasien->transform(function ($item) {
            $item->tgl_lahir = Carbon::parse($item->tgl_lahir)->format('d-m-Y');
            return $item;
        });

        return response()->json(['pasien' => $pasien]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
