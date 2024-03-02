<?php

namespace App\Http\Controllers;

use App\Models\ModelAntrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AntrianController extends Controller
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
        $antrian = DB::table('antrian')
            ->select('antrian.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
            ->join('pasien', 'antrian.kartu', '=', 'pasien.kartu') // Join based on the foreign key relationship
            ->whereNull('antrian.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('antrian.created_at', now()->toDateString())
            ->whereNotIn('antrian.id', function ($query) {
                $query->select('pelayanan.antrian_id')->from('pelayanan');
            })
            ->orderBy('antrian.created_at', 'asc')
            ->get();

        // dd($antrian);
        return view('antrian.antrian_view')->with(compact('antrian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasien = DB::table('pasien')
            ->select('*')
            ->whereNull('pasien.deleted_at') // Filter for today's date in the 'pasien' table
            ->orderBy('nama', 'desc')
            ->get();

        // dd($antrian);
        return view('antrian.antrian_create_view')->with(compact('pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'max:16'],
            'nama' => ['required', 'string', 'max:255'],
            'kartu' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        // Store only the 'kartu' field in the database
        ModelAntrian::create(['kartu' => $validatedData['kartu']]);
        return redirect()->route('antrian.index')
            ->with('success', 'Berhasil Menambahkan Antrian Pasien');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pasien =  DB::table('pasien')
        ->select('*')
        ->where('id', '=', $id)
        ->get();

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
        $modelAntrian = ModelAntrian::find($id);
        if ($modelAntrian) {
            $modelAntrian->delete();
        }
    }
}
