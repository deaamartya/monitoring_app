<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use App\Models\Tipe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;

class RencanaController extends Controller
{
    public function show($id){

        $progress = Proyek::select('proyek.KODE_PROYEK', 'p1.TANGGAL', DB::raw('COALESCE(p1.VALUE,"-") AS PV'),  DB::raw('COALESCE(p2.VALUE,"-") AS Rencana'))
        ->join('progress as p1', 'p1.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->join('progress as p2', 'p2.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->where(['proyek.KODE_PROYEK' => $id, 'p1.ID_TIPE' => 1, 'p2.ID_TIPE' => 4, "p2.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))"),])
        ->orderByDesc('p1.TANGGAL')
        ->get();
        $kode_proyek = $id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        
        $current_year = date('Y');
        $jml_proyek_this_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->month
        )->whereYear('TANGGAL', date('Y'))->count();
        $jml_proyek_last_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->subMonth()->month
        )->whereYear('TANGGAL', date('Y'))->count();
      

        return view('admin.rencana',compact('progress', 'current_year', 'jml_proyek_this_month', 'jml_proyek_last_month', 'nama_proyek', 'kode_proyek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TANGGAL' => 'required'
        ]);

        $date=Carbon::parse($request->TANGGAL);
        $date->format('d-m-Y'); 
        
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
