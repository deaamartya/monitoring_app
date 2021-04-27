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

        $jml_proyek_this_month  = Proyek::whereMonth(
            'created_at', '=', Carbon::now()->month
        )->whereYear('created_at', date('Y'))->count();

        $jml_proyek_last_month  = Proyek::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        )->whereYear('created_at', date('Y'))->count();

        $jml_proyek_this_year  = Proyek::whereYear('created_at', date('Y'))->count();

        $jml_proyek_last_year  = Proyek::whereYear('created_at', Carbon::now()->subYear()->year)->count();

        $jml_proyek_all  = Proyek::count();

        $pv = Progress::
        select('progress.VALUE', 'tipe.NAMA_TIPE')
        ->join('TIPE', 'tipe.ID_TIPE', '=', 'progress.ID_TIPE')
        ->where('progress.ID_TIPE', '=', 1)
        ->get();

        $current_year = date('Y');

        $first_year = Proyek::orderBy('created_at','ASC')->value('created_at');
        $first_year = intval(date('Y', strtotime($first_year)));

        $last_year = Proyek::orderBy('created_at','DESC')->value('created_at');
        $last_year = intval(date('Y', strtotime($last_year)));

        if($first_year != $last_year){
            for($j=$first_year;$j<=$last_year;$j++){
                $data[$j] = new \stdClass();
                $data[$j]->VALUE = Proyek::whereYear('created_at', $j)->count();
                $data[$j]->TAHUN = $j;
            }
        }
        elseif($first_year == $last_year){
            for($j=$first_year;$j<=$first_year+5;$j++){
                $data[$j] = new \stdClass();
                $data[$j]->VALUE = Proyek::whereYear('created_at', $j)->count();
                $data[$j]->TAHUN = $j;
            }
        }

        $list_realisasi = Progress::where(
            'ID_TIPE','=',2)->orWhere('ID_TIPE','=',3)->orWhere('ID_TIPE','=',5)->orderBy('created_at','DESC')->get()->limit(5);

        return view('dashboard', compact('progress', 'current_year', 'jml_proyek_this_month', 'jml_proyek_last_month','jml_proyek_this_year', 'jml_proyek_last_year','jml_proyek_all', 'data','list_realisasi'));
    }

}

