<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use Illuminate\Http\Request;

class RencanaController extends Controller
{
    public function index($id){
       
        $progress = Progress::where('KODE_PROYEK', $id)->get();
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        return view('admin.rencana',compact('progress', 'nama_proyek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TANGGAL' => 'required',
            'PV_VALUE' => 'required',
            'RENCANA' => 'required'
        ]);

        Progress::insert([
            'TANGGAL' => $request->TANGGAL,
            'PV_VALUE' => $request->PV_VALUE,
            'RENCANA' => $request->RENCANA
        ]);
        
        return redirect('admin/rencana')->with('success','Rencana berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TANGGAL' => 'required',
            'PV_VALUE' => 'required',
            'RENCANA' => 'required'
        ]);

        Progress::find($id)->update([
            'TANGGAL' => $request->TANGGAL,
            'PV_VALUE' => $request->PV_VALUE,
            'RENCANA' => $request->RENCANA
        ]);

        return redirect('admin/rencana')->with('success','Rencana berhasil diupdate.');
    }

    public function destroy($id)
    {
        Progress::find($id)->update([
            'TANGGAL' => null,
            'PV_VALUE' => null,
            'RENCANA' => null
        ]);

        return redirect('admin/rencana')->with('success','Rencana berhasil dihapus.');
    }
}
