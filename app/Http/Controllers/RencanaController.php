<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use Illuminate\Http\Request;

class RencanaController extends Controller
{
    public function index($id){
        $progress = Progress::where('KODE_PROYEK', $id)
        ->whereNotNull('TANGGAL')
        ->orWhereNotNull('PV_VALUE')
        ->orWhereNotNull('RENCANA')
        ->orderByDesc('TANGGAL')
        ->get();
        $kode_proyek =$id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        return view('admin.rencana',compact('progress', 'nama_proyek', 'kode_proyek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TANGGAL' => 'required',
            'PV_VALUE' => 'required',
           
            'RENCANA' => 'required'
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->update([
            'PV_VALUE' => $request->EV_VALUE,
           
            'RENCANA' => $request->RENCANA
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
            'PV_VALUE' => $request->EV_VALUE_EDIT,
            
            'RENCANA' => $request->REALISASI_EDIT
        ]);

        return redirect()->back()->with('success','Data rencana berhasil diupdate.');
    }

    public function destroy($id, Request $request)
    {
        Progress::where('KODE_PROYEK',$id)->update([
            'PV_VALUE' => NULL,
           
            'RENCANA' => NULL
        ]);

        return redirect()->back()->with('success','Data rencana berhasil dihapus.');
    }
}
