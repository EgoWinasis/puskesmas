<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use PDF;
use Carbon\Carbon;

class CetakController extends Controller
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
        $currentMonth = now()->month;
        $currentYear = now()->year;
        if (Auth::user()->role == 'admin') {
            $pelayanan = DB::table('pelayanan')
                ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
                ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
                ->whereNull('pelayanan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereMonth('pelayanan.created_at', $currentMonth)
                ->whereYear('pelayanan.created_at', $currentYear) // Filter for today's date in the 'pelayanan' table
                ->orderBy('pelayanan.created_at', 'desc')
                ->get();
            return view('cetak.cetak_pelayanan_admin_view')->with(compact('pelayanan'));
        }
        if (Auth::user()->role == 'dokter') {
            $pemeriksaan = DB::table('pemeriksaan')
                ->select('pemeriksaan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
                ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
                ->whereNull('pemeriksaan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereMonth('pemeriksaan.created_at', $currentMonth)
                ->whereYear('pemeriksaan.created_at', $currentYear) // Filter for today's date in the 'pemeriksaan' table
                ->orderBy('pemeriksaan.created_at', 'desc')
                ->get();
            return view('cetak.cetak_pemeriksaan_dokter_view')->with(compact('pemeriksaan'));
        }
        if (Auth::user()->role == 'apoteker') {
            $obat = DB::table('obat')
                ->select('obat.*', 'pasien.id as pasien_id', 'pemeriksaan.tujuan','pasien.nik', 'pasien.nama', 'pasien.alamat')
                ->join('pasien', 'obat.pasien_id', '=', 'pasien.id')
                ->join('pemeriksaan', 'obat.pemeriksaan_id', '=', 'pemeriksaan.id')
                ->whereNull('obat.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereNull('pemeriksaan.deleted_at')
                ->whereMonth('obat.created_at', $currentMonth)
                ->whereYear('obat.created_at', $currentYear)
                ->orderBy('obat.created_at', 'desc')
                ->get();
            // dd($obat);
            return view('cetak.cetak_apoteker_view')->with(compact('obat'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Create an instance of mPDF
        $mpdf = new Mpdf();
        $cuti = DB::table('cuti')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        // Your content - replace this with your HTML content or view rendering

        // status 
        $arrayJenisCuti = [
            'Cuti Tahunan',
            'Cuti Besar',
            'Cuti Sakit',
            'Cuti Bersalin',
            'Cuti Karena Alasan Penting',
            'Keterangan Lain'
        ];
        $jenisCutiTag = "";
        foreach ($cuti as $row) {

            $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
            $dateWithoutTime = $date->startOfDay();
            Carbon::setLocale('id');
            $dateIndo = $dateWithoutTime->isoFormat('D MMMM Y');
            // 
            $name = $row->name;
            $nip = $row->nip;
            $pangkat = $row->pangkat;
            $jabatan = $row->jabatan;
            $jenisCuti = $row->jenis_cuti;
            $hari = $row->hari;
            $status = $row->status;
            $approve_by = $row->approve_by;
            $alamat_cuti = $row->alamat_cuti;

            if (strpos($row->tgl_cuti, ' to ') !== false) {
                // Extracting start and end dates
                $dates = explode(' to ', $row->tgl_cuti);
            }
            if (count($dates) === 2) {
                $startDate = Carbon::createFromFormat('Y-m-d', $dates[0]);
                $endDate = Carbon::createFromFormat('Y-m-d', $dates[1]);

                // Set the locale to Indonesian
                Carbon::setLocale('id');

                // Format the start and end dates in Indonesian format
                $startDateIndo = $startDate->isoFormat('D MMMM Y');
                $endDateIndo = $endDate->isoFormat('D MMMM Y');
                $tagCuti = " Dengan ini mengajukan Cuti Tahunan selama <b>$hari hari</b> terhitung mulai tanggal <b>$startDateIndo</b> s/d <b>$endDateIndo</b> dan selama menjalankan cuti tahunan alamat berada di <b>$alamat_cuti</b>";
            } else {
                $startDate = Carbon::createFromFormat('Y-m-d', $row->tgl_cuti);
                Carbon::setLocale('id');
                $startDateIndo = $startDate->isoFormat('D MMMM Y');
                $tagCuti = " Dengan ini mengajukan Cuti Tahunan selama <b>$hari hari</b> di tanggal <b>$startDateIndo</b>  dan selama menjalankan cuti tahunan alamat berada di <b>$alamat_cuti</b>";
            }
        }

        // jenis cuti
        $i = 1;
        foreach ($arrayJenisCuti as $jenis_cuti) {
            $style = '';
            if ($jenis_cuti != $jenisCuti) {
                $style = 'text-decoration: line-through;';
            }
            if ($jenis_cuti == $jenisCuti) {
                $style = 'font-weight:bold;';
            }
            $jenisCutiTag .= "<span style='{$style}'>$i. $jenis_cuti</span><br>";
            $i++;
        }


        // user
        $user = DB::table('users')
            ->select('ttd')
            ->where('name', '=', $name)
            ->get();

        foreach ($user as $row) {
            $ttdUser = $row->ttd;
        }
        // atasan
        $atasan = DB::table('users')
            ->select('name', 'nip', 'bagian', 'ttd')
            ->where('name', '=', $approve_by)
            ->get();

        foreach ($atasan as $row) {
            $namaAtasan = $row->name;
            $nipAtasan = $row->nip;
            $bagianAtasan = strtoupper($row->bagian);
            $ttdAtasan = $row->ttd;
        }
        // sisa cuti


        $totalHari = DB::table('cuti')
            ->where('nip', '=', Auth::user()->nip)
            ->where('status', '=', 'Disetujui')
            ->sum('hari');
        $sisaCuti = 12 - $totalHari;
        if ($totalHari != 0) {
            $tagFooter = "Sudah pernah cuti <b>$totalHari hari</b>  / Sisa Cuti <b>$sisaCuti hari</b>";
        } else {
            $tagFooter = "Belum pernah cuti  / Sisa Cuti <b>$sisaCuti hari</b>";
        }

        $htmlContent = "
        <div style='border-bottom:2px solid black;'>
            <h3 style='text-align:center'>PERMINTAAN CUTI TAHUNAN </h3>
            </div>
            <header>
            <table width='100%' >
                <tr>
                    <td width='40%'></td>
                    <td colspan='3'>LAMPIRAN II SURAT EDARAN KEPALA <br>BADAN ADMINISTRASI KEPEGAWAIAN NEGARA</td>
                </tr>
                <tr >
                    <td></td>
                    <td width='15%'>
                        NOMOR
                    </td>
                    <td width='5%'>
                        :
                    </td>
                    <td>
                        01/SE/1977
                    </td>
                </tr>
                <tr >
                    <td></td>
                    <td >
                        TANGGAL
                    </td>
                    <td>
                        :
                    </td>
                    <td >
                        25 FEBRUARI 1977
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style='border-bottom: 2px solid black;' colspan='3 '></td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td style='padding-top:20px;padding-left:20px;' colspan='3'>
                        Suradadi, $dateIndo
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td style='text-align:center; padding-top:15px' colspan='3'>
                        Kepada Yth: <br> Direktur RSUD Suradadi <br> Kabupaten Tegal
                    </td>
                </tr>
            </table>
            </header>
            <main style='margin-top:10px;'>
            <table width='100%'>
                <tr>
                    <td colspan='3' width='100%'>
                        Yang bertanda tangan dibawah ini :
                    </td>
                </tr>
                <tr>
                    <td width='30%'>
                        Nama
                    </td>
                    <td width='2%'>
                        :
                    </td>
                    <td>
                        $name
                    </td>
                </tr>
                <tr>
                    <td >
                        NIP / NIPB
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        $nip
                    </td>
                </tr>
                <tr>
                    <td>
                        Pangkat/Gol. Ruang
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        $pangkat
                    </td>
                </tr>
                <tr>
                    <td>
                        Jabatan Satuan Organisasi
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        $jabatan
                    </td>
                </tr>
                <tr>
                    <td style='padding-top:20px;' colspan='3'>
                       $tagCuti
                    </td>
                </tr>
                <tr>
                    <td style='padding-top:10px;' colspan='3'>
                        Demikian permintaan cuti ini saya buat untuk digunakan sebagaimana mestinya.
                    </td>
                </tr>
            </table>
            </main>
            <div class='ttd'>
            <table width='100%'>
                <tr>
                    <td width='55%'></td>
                    <td style='padding-top:20px; text-align:center; '>
                        Hormat Saya,
                    </td>
                </tr>
                <tr>
                    <td ></td>
                    <td style='text-align:center;' >
                    <img src='storage/ttd/$ttdUser' alt='tanda Tangan' width='100px'>
                    </td>
                </tr>
                <tr>
                    <td ></td>
                    <td style='text-align:center;' >
                        <b>$name</b>
                    </td>
                </tr>
               
                <tr>
                    <td ></td>
                    <td  style='padding-top:5px;text-align:center; ' >
                        <span style=' border-top:2px solid black;'>
                        NIP/NIPB. $nip
                        </span>
                    </td>
                    <td></td>
                </tr>
            </table>
            </div>
            <div class='catatan' style='margin-top: 1%;'>
            <table width='100%' style='border: 1px solid black; border-collapse: collapse;'>
                <tr>
                    <td width='40%' style='text-align: left; padding-left:2%;padding-top: 5px; border-right: 1px solid black;'>
                        CATATAN PEJABAT KEPEGAWAIAN <br> cuti yang akan diambil tahun ini <br>adalah :
                    </td>
                    <td width='60%' style='text-align: center; padding-top: 5px; '>
                        CATATAN PERTIMBANGAN ATASAN LANGSUNG <br> $bagianAtasan <br> RSUD SURADADI KABUPATEN TEGAL
                    </td>
                </tr>
                <tr>
                    <td width='40%' style=' text-align: left; padding-left:2%; border-right: 1px solid black;'>
                        $jenisCutiTag
                    </td>
                    <td width='60%' style='text-align: center; '>
                        <img src='storage/ttd/$ttdAtasan' alt='tanda Tangan' width='100px'>
                    </td>
                </tr>
                <tr>
                    <td width='40%' style=' text-align: center; border-right: 1px solid black;'>
                    </td>
                    <td width='60%' style=' text-align: center; '>
                        <b>$namaAtasan</b>
                    </td>
                </tr>
              
        
                <tr>
                    <td width='40%' style='padding-top: 5px; text-align: center; border-right: 1px solid black;'>
                    </td>
                    <td width='60%' style='padding-top: 2px;padding-bottom: 15px; text-align: center; '>
                        <span style='border-top: 2px solid black;'>NIP. $nipAtasan</span>
                    </td>
                </tr>
                <tr>
                    <td width='40%' style='padding-top: 3%; text-align: center;  border-right: 1px solid black;'>
                    </td>
                    <td width='60%' style='padding-top: 5px; padding-bottom: 1%; text-align: left; border-top: 1px solid black; '>
                        KEPUTUSAN PEJABAT YANG BERWENANG MEMBERI CUTI : <b>$status</b>
                    </td>
                </tr>
            </table>
            </div>
            <div class='footer'>
            <p style=' text-align: left; padding-left:2%;'>
               $tagFooter
            </p>
        </div>

        
        ";

        // Add your HTML content to mPDF
        $mpdf->WriteHTML($htmlContent);

        // Output the PDF as a download
        $mpdf->Output('document.pdf', 'D'); // 'D' forces download, 'I' opens in the browser

        exit;
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
