<?php

namespace App\Http\Controllers;

use App\Models\ModelPelayanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PelayananController extends Controller
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
        if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apoteker') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        if (Auth::user()->role == 'admin') {

            $pelayanan = DB::table('pelayanan')
            ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
            ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
            ->whereNull('pelayanan.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('pelayanan.created_at', now()->toDateString()) // Filter for today's date in the 'pelayanan' table
            ->orderBy('pelayanan.created_at', 'asc')
            ->get();
            return view('pelayanan.pelayanan_view')->with(compact('pelayanan'));
        }
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
        $validatedData = $request->validate([
            'pasien_id' => ['required', 'string', 'max:11'],
            'antrian_id' => ['required', 'string', 'max:11'],
            'nik' => ['required', 'string', 'max:16'],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'tujuan' => ['required', 'string', 'max:255'],
            'keluhan' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);


        // Store only the specified fields in the database
        ModelPelayanan::create([
            'pasien_id' => $validatedData['pasien_id'],
            'antrian_id' => $validatedData['antrian_id'],
            'tujuan' => $validatedData['tujuan'],
            'keluhan' => Str::ucfirst($validatedData['keluhan']),
            'catatan' => Str::ucfirst($validatedData['catatan']),
        ]);

        return redirect()->route('antrian.index')
            ->with('success', 'Berhasil Menambahkan Data Pelayanan Pasien');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelayanan = DB::table('pelayanan')
            ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik','pasien.bpjs','pasien.tgl_lahir', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
            ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
            ->where('pasien.id', $id) // Filter by specific pasien_id
            ->whereNull('pelayanan.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('pelayanan.created_at', now()->toDateString()) // Filter for today's date in the 'pelayanan' table
            ->orderBy('pelayanan.created_at', 'asc')
            ->get();
            
            $pelayanan->transform(function ($item) {
                $item->tgl_lahir = Carbon::parse($item->tgl_lahir)->format('d-m-Y');
                return $item;
            });
            
            return response()->json(['pelayanan' => $pelayanan]);
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
        // $cuti = ModelCuti::find($id); // Find the record by ID
        // if (Auth::user()->role == 'admin') {
        //     $cuti->status_admin = "Disetujui";
        //     $cuti->save();
        // }
        // if (Auth::user()->role == 'kepala') {
        //     $cuti->status = "Disetujui";
        //     $cuti->approve_by = Auth::user()->name;
        //     $cuti->save();
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modelPelayanan = ModelPelayanan::find($id);
        if ($modelPelayanan) {
            $modelPelayanan->delete();
        }
    }
}
