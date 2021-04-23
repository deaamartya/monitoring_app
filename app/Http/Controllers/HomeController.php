<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Proyek;
use App\Models\Tipe;
use Illuminate\Support\Carbon;

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
    public function index(){
        $progress=Progress::all();
        $current_year = date('Y');
        $jml_proyek_this_month  = Proyek::all()->count();
        $jml_proyek_last_month  = Proyek::whereMonth(
            'START_PROYEK', '=', Carbon::now()->subMonth()->month
        )->whereYear('START_PROYEK', date('Y'))->count();

        $pv = Progress::
        select('progress.VALUE', 'tipe.NAMA_TIPE')
        ->join('TIPE', 'tipe.ID_TIPE', '=', 'progress.ID_TIPE')
        ->where('progress.ID_TIPE', '=', 1)
        ->get();

        $current_year = date('Y');

        $januari = Progress::whereMonth('TANGGAL','01')->whereYear('TANGGAL',date('Y'))->count();
        $februari = Progress::whereMonth('TANGGAL','02')->whereYear('TANGGAL',date('Y'))->count();
        $maret = Progress::whereMonth('TANGGAL','03')->whereYear('TANGGAL',date('Y'))->count();
        $april= Progress::whereMonth('TANGGAL','04')->whereYear('TANGGAL',date('Y'))->count();
        $mei = Progress::whereMonth('TANGGAL','05')->whereYear('TANGGAL',date('Y'))->count();
        $juni = Progress::whereMonth('TANGGAL','06')->whereYear('TANGGAL',date('Y'))->count();
        $juli = Progress::whereMonth('TANGGAL','07')->whereYear('TANGGAL',date('Y'))->count();
        $agustus = Progress::whereMonth('TANGGAL','08')->whereYear('TANGGAL',date('Y'))->count();
        $september= Progress::whereMonth('TANGGAL','09')->whereYear('TANGGAL',date('Y'))->count();
        $oktober= Progress::whereMonth('TANGGAL','10')->whereYear('TANGGAL',date('Y'))->count();
        $november = Progress::whereMonth('TANGGAL','11')->whereYear('TANGGAL',date('Y'))->count();
        $desember = Progress::whereMonth('TANGGAL','12')->whereYear('TANGGAL',date('Y'))->count();

        return view('dashboard', compact('progress', 'current_year', 'jml_proyek_this_month', 'jml_proyek_last_month', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'));
    }

    public function grafik(){
        // Statistik Penjualan
        $data_grafik = [];

        for($i=1;$i<=12;$i++)
        {
            $date = Carbon::create(date("Y"), $i, 1, 12, 0, 0)->startOfMonth();
            $date_end = Carbon::create(date("Y"), $i, 1, 12, 0, 0)->endOfMonth();

            $data_grafik[$i] = Progress::select('product.KODE_PRODUCT','product.NAMA_PRODUCT',DB::raw('
                CASE WHEN d.ID_PENJUALAN IN(
                    SELECT pp.ID_PENJUALAN FROM penjualan p 
                    JOIN pembayaran_penjualan pp on pp.ID_PENJUALAN = p.ID_PENJUALAN 
                    WHERE pp.STATUS_PEMBAYARAN = 1 AND DATE(TGL_PENJUALAN) BETWEEN "'.date("Y-m-d",strtotime($date)).'" AND "'.date("Y-m-d",strtotime($date_end)).'")
                        THEN SUM(d.JUMLAH_PCS)
                        ELSE 0
                END AS JUMLAH_PCS'))->leftJoin('detil_penjualan as d','d.KODE_PRODUCT','=','product.KODE_PRODUCT')->groupBy('product.KODE_PRODUCT','product.NAMA_PRODUCT')->get();

            $data_grafik[$i]["bulan"] = $date->locale('id_ID')->monthName;
        }

        for($i=1;$i<=12;$i++)
        {
            
            $date = Carbon::create(date("Y"), $i, 1, 12, 0, 0)->startOfMonth();
            $date_end = Carbon::create(date("Y"), $i, 1, 12, 0, 0)->endOfMonth();

            $data_grafik_keseluruhan[$i] = DetilPenjualan::select(DB::raw('
                COALESCE(SUM(JUMLAH_PCS),0) AS JUMLAH_PCS'))->join('penjualan as p','p.ID_PENJUALAN','=','detil_penjualan.ID_PENJUALAN')->join('pembayaran_penjualan as pp','pp.ID_PENJUALAN','=','p.ID_PENJUALAN')->where('pp.STATUS_PEMBAYARAN','=',1)->whereBetween(DB::raw('DATE(TGL_PENJUALAN)'),[$date,$date_end])->get();

            $data_grafik_keseluruhan[$i]["bulan"] = $date->locale('id_ID')->monthName;
        }

		return view('dashboard')->with(compact('pemasukan', 'data_transaksi', 'data_grafik_keseluruhan', 'pengeluaran'));
	}
}

