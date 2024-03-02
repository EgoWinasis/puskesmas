<?php

namespace App\Http\Controllers;

use App\Models\ModelPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
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

        $pemeriksaan = DB::table('pemeriksaan')
            ->select('pemeriksaan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
            ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
            ->whereNull('pemeriksaan.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('pemeriksaan.created_at', now()->toDateString()) // Filter for today's date in the 'pemeriksaan' table
            ->orderBy('pemeriksaan.created_at', 'asc')
            ->get();


        return view('pemeriksaan.pemeriksaan_view')->with(compact('pemeriksaan'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pemeriksaan = DB::table('pemeriksaan')
            ->select(
                'pemeriksaan.*',
                'pasien.id as pasien_id',
                'pasien.nik',
                'pasien.bpjs',
                'pasien.tgl_lahir',
                'pasien.nama',
                'pasien.alamat'
            )
            ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id')
            ->where('pasien.id', $id) // Filter by specific pasien_id
            ->whereNull('pemeriksaan.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('pemeriksaan.created_at', now()->toDateString())
            ->orderBy('pemeriksaan.created_at', 'asc')
            ->get();


        return response()->json(['pemeriksaan' => $pemeriksaan]);
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
        $pemeriksaan = ModelPemeriksaan::find($id);

        if ($pemeriksaan) {
            // The object exists, so you can safely access its properties
            $pemeriksaan->diagnosa = $request->input('diagnosa');
            $pemeriksaan->obat = $request->input('obat');
            // Save the object
            $pemeriksaan->save();

            return response()->json(['message' => 'Data updated successfully']);
        } else {
            // Handle the case where the object does not exist
            return response()->json(['message' => 'Pemeriksaan not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
