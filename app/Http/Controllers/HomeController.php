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
        $ev = Progress::
        select('progress.VALUE', 'tipe.NAMA_TIPE')
        ->join('TIPE', 'tipe.ID_TIPE', '=', 'progress.ID_TIPE')
        ->where('progress.ID_TIPE', '=', 2)
        ->get();
        $ac = Progress::
        select('progress.VALUE', 'tipe.NAMA_TIPE')
        ->join('TIPE', 'tipe.ID_TIPE', '=', 'progress.ID_TIPE')
        ->where('progress.ID_TIPE', '=', 3)
        ->get();
        $rencana= Progress::
        select('progress.VALUE', 'tipe.NAMA_TIPE')
        ->join('TIPE', 'tipe.ID_TIPE', '=', 'progress.ID_TIPE')
        ->where('progress.ID_TIPE', '=', 4)
        ->get();
        $realisasi = Progress::
        select('progress.VALUE', 'tipe.NAMA_TIPE')
        ->join('TIPE', 'tipe.ID_TIPE', '=', 'progress.ID_TIPE')
        ->where('progress.ID_TIPE', '=', 5)
        ->get();

        return view('dashboard', compact('progress', 'current_year', 'jml_proyek_this_month', 'jml_proyek_last_month', 'pv', 'ev', 'ac', 'rencana', 'realisasi'));
    }
}
