<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use App\Models\Tipe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use DB;

class RencanaController extends Controller
{
    public function index(){
        $proyek = Proyek::all();
        return view('admin.rencana_index',compact('proyek'));
    }

    public function show($id){

        $progress = Proyek::select('proyek.KODE_PROYEK', 'p1.TANGGAL', DB::raw('COALESCE(p1.VALUE,"-") AS PV'),  DB::raw('COALESCE(p2.VALUE,"-") AS Rencana'))
        ->join('progress as p1', 'p1.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->join('progress as p2', 'p2.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->where(['proyek.KODE_PROYEK' => $id, 'p1.ID_TIPE' => 1, 'p2.ID_TIPE' => 4, "p2.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))"),])
        ->orderByDesc('p1.TANGGAL')
        ->get();
        $kode_proyek = $id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        $start_proyek = Proyek::where('KODE_PROYEK', $id)->value('START_PROYEK');
        $end_proyek = Proyek::where('KODE_PROYEK', $id)->value('END_PROYEK');
        
        $current_year = date('Y');
        $jml_proyek_this_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->month
        )->whereYear('TANGGAL', date('Y'))->count();
        $jml_proyek_last_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->subMonth()->month
        )->whereYear('TANGGAL', date('Y'))->count();

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
      

        return view('admin.rencana',compact('progress', 'current_year', 'jml_proyek_this_month', 'jml_proyek_last_month', 'nama_proyek', 'kode_proyek', 'start_proyek', 'end_proyek', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bln' => 'required',
            'thn' => 'required'
        ]);

        $request->bln = ($request->bln < 10) ? "0".$request->bln : $request->bln;
        $date= $request->thn."-".$request->bln."-01";

        if(Progress::where('TANGGAL', '=' , $date)->exists()){
            throw ValidationException::withMessages(['messages' => 'Sudah terdapat rencana pada bulan dan tahun tersebut.']);
        }
        else{
        // Insert PV
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 1,
            'VALUE' => $request->PV_VALUE,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
        // Insert rencana
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 4,
            'VALUE' => $request->RENCANA_VALUE,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
         // Insert EV
         Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 2,
            'VALUE' => null,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
         // Insert AC
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 3,
            'VALUE' => null,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
        // Insert REALISASI
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 5,
            'VALUE' => null,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
        }

        return redirect()->back()->with('success','Data rencana berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'PV_VALUE_EDIT' => 'required',
        //     'RENCANA_EDIT' => 'required'
        // ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '1')->update([
            'VALUE' => $request->PV_VALUE_EDIT,
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '4')->update([
            'VALUE' => $request->RENCANA_VALUE_EDIT,
        ]);
        return redirect()->back()->with('success','Data rencana berhasil diupdate.');
    }

    public function destroy($id, Request $request)
    {
      Progress::where([
          'KODE_PROYEK' => $id,
          'TANGGAL' => $request->TANGGAL_DELETE
      ])->delete();
       
           

        return redirect()->back()->with('success','Data rencana berhasil dihapus.');
    }
}
