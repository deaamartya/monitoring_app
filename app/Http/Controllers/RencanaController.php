<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use App\Models\Tipe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RencanaController extends Controller
{
    public function show($id){

        $progress = Progress::where('KODE_PROYEK', $id)
        ->orderByDesc('TANGGAL')
        ->get();
        $tipe = Tipe::all();
      
        $kode_proyek = $id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');

        $progress2=Progress::all();
        $current_year = date('Y');
        $jml_proyek_this_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->month
        )->whereYear('TANGGAL', date('Y'))->count();
        $jml_proyek_last_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->subMonth()->month
        )->whereYear('TANGGAL', date('Y'))->count();

        $pv = Progress::all();
        $ev = Progress::all();
        $ac = Progress::all();
        $rencana= Progress::all();
        $realisasi = Progress::all();

        return view('admin.rencana',compact('progress', 'progress2', 'current_year', 'jml_proyek_this_month', 'jml_proyek_last_month', 'pv', 'ev', 'ac', 'rencana', 'realisasi', 'nama_proyek', 'kode_proyek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TANGGAL' => 'required',
            'PV_VALUE' => 'required',
            'RENCANA' => 'required'
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
            'VALUE' => $request->RENCANA,
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
        $request->validate([
            'PV_VALUE_EDIT' => 'required',
            'RENCANA_EDIT' => 'required'
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->update([
            'PV_VALUE' => $request->PV_VALUE_EDIT,
            'RENCANA' => $request->RENCANA_EDIT
        ]);
        return redirect()->back()->with('success','Data rencana berhasil diupdate.');
    }

    public function destroy($id, Request $request)
    {
      Progress::where([
          'KODE_PROYEK' => $id,
          'TANGGAL' => $request->TANGGAL,
          'ID_TIPE' => $request->ID_TIPE
      ])->delete();
       
           

        return redirect()->back()->with('success','Data rencana berhasil dihapus.');
    }
}
