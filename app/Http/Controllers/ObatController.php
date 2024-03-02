<?php

namespace App\Http\Controllers;

use App\Models\ModelObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
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
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'dokter') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }

        $pemeriksaan = DB::table('pemeriksaan')
            ->select('pemeriksaan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat')
            ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id')
            ->leftJoin('obat', 'pemeriksaan.id', '=', 'obat.pemeriksaan_id') // Left join with 'obat' table
            ->whereNull('pemeriksaan.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereNull('obat.pemeriksaan_id') // Filter out records where a corresponding 'obat' record exists
            ->whereDate('pemeriksaan.created_at', now()->toDateString())
            ->orderBy('pemeriksaan.created_at', 'asc')
            ->get();


        return view('apoteker.apoteker_view')->with(compact('pemeriksaan'));
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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'pemeriksaan_id' => 'required|integer',
            'pasien_id' => 'required|integer',
            'obat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Store the data
        $obat = new ModelObat();
        $obat->pemeriksaan_id = $request->pemeriksaan_id;
        $obat->pasien_id = $request->pasien_id;
        $obat->obat = $request->obat;
        $obat->save();

        return response()->json(['message' => 'Data saved successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
