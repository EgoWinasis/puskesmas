<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        if (Auth::user()->isActive == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive. Please contact Admin support.');
        }
        if (Auth::user()->role == 'user') {
            $totalHari = DB::table('pasien')
                ->where('nip', '=', Auth::user()->nip)
                ->where(function ($query) {
                    $query->where('status', '=', 'Pending')
                        ->orWhere('status', '=', 'Disetujui');
                })
                ->sum('hari');
            $batalCount = DB::table('pasien')
                ->where('nip', '=', Auth::user()->nip)
                ->where('status', '=', 'Batal')
                ->count();
            $pendingCount = DB::table('pasien')
                ->where('nip', '=', Auth::user()->nip)
                ->where('status', '=', 'Pending')
                ->count();
            $disetujuiCount = DB::table('pasien')
                ->where('nip', '=', Auth::user()->nip)
                ->where('status', '=', 'Disetujui')
                ->count();
            $ditolakCount = DB::table('pasien')
                ->where('nip', '=', Auth::user()->nip)
                ->where('status', '=', 'Ditolak')
                ->count();

            return view('home', compact('totalHari', 'batalCount', 'disetujuiCount', 'pendingCount', 'ditolakCount'));
        }
        if (Auth::user()->role == 'admin') {
            $pelayanan = DB::table('pelayanan')
                ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
                ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
                ->whereNull('pelayanan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereDate('pelayanan.created_at', now()->toDateString()) // Filter for today's date in the 'pelayanan' table
                ->orderBy('pelayanan.created_at', 'asc')
                ->count();

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
                ->count();

            $pasien = DB::table('pasien')
                ->select('*')
                ->whereNull('deleted_at')
                ->count();

            $totalUsersActive = DB::table('users')
                ->where('isActive', '=', '1')
                ->count();
            $totalUsersInActive = DB::table('users')
                ->where('isActive', '=', '0')
                ->count();

            return view('home', compact('totalUsersActive', 'totalUsersInActive', 'pasien', 'antrian', 'pelayanan'));
        }
        if (Auth::user()->role == 'dokter') {

            $pemeriksaan = DB::table('pemeriksaan')
                ->select('pemeriksaan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
                ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
                ->whereNull('pemeriksaan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereDate('pemeriksaan.created_at', now()->toDateString()) // Filter for today's date in the 'pemeriksaan' table
                ->orderBy('pemeriksaan.created_at', 'asc')
                ->count();


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
                ->count();




            return view('home', compact('antrian', 'pemeriksaan'));
        }
        if (Auth::user()->role == 'apoteker') {

            $antrian = DB::table('pemeriksaan')
                ->select('pemeriksaan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat')
                ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id')
                ->leftJoin('obat', 'pemeriksaan.id', '=', 'obat.pemeriksaan_id') // Left join with 'obat' table
                ->whereNull('pemeriksaan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereNull('obat.pemeriksaan_id') // Filter out records where a corresponding 'obat' record exists
                ->whereDate('pemeriksaan.created_at', now()->toDateString())
                ->orderBy('pemeriksaan.created_at', 'asc')
                ->count();


            $obat = DB::table('obat')
                ->select('obat.*', 'pasien.id as pasien_id', 'pemeriksaan.tujuan', 'pasien.nik', 'pasien.nama', 'pasien.alamat')
                ->join('pasien', 'obat.pasien_id', '=', 'pasien.id')
                ->join('pemeriksaan', 'obat.pemeriksaan_id', '=', 'pemeriksaan.id')
                ->whereNull('obat.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereNull('pemeriksaan.deleted_at')
                ->whereMonth('obat.created_at', $currentMonth)
                ->whereYear('obat.created_at', $currentYear)
                ->orderBy('obat.created_at', 'desc')
                ->count();




            return view('home', compact('obat', 'antrian'));
        }
    }
}
