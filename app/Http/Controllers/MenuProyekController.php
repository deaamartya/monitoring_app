<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Exports\ProyekExport;
use Maatwebsite\Excel\Facades\Excel;

class MenuProyekController extends Controller
{
    public function index(){
        $proyek = Proyek::all();
        return view('admin.menuproyek',compact('proyek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'KODE_PROYEK' => 'required',
            'NAMA_PROYEK' => 'required',
            'START_PROYEK' => 'required',
            'END_PROYEK' => 'required'
        ]);

        Proyek::insert([
            'KODE_PROYEK' => $request->KODE_PROYEK,
            'NAMA_PROYEK' => $request->NAMA_PROYEK,
            'START_PROYEK' => date('Y-m-d',strtotime($request->START_PROYEK)),
            'END_PROYEK' => date('Y-m-d',strtotime($request->END_PROYEK)),
            'LAST_UPDATE' => now(),
            'CREATED_AT' => now()
        ]);
        
        return redirect()->back()->with('message','Success');
    }

    public function update(Request $request){

        Proyek::where('ID_PROYEK',$request->ID_PROYEK)
        ->update([
            'KODE_PROYEK' => $request->KODE_PROYEK,
            'NAMA_PROYEK' => $request->NAMA_PROYEK,
            'START_PROYEK' => $request->START_PROYEK,
            'END_PROYEK' => $request->END_PROYEK,
            'LAST_UPDATE' => now()    
        ]);

        return redirect()->back()->with('success','Data proyek berhasil diupdate.');
    }

    public function destroy($id, Request $request)
    {
        Proyek::where([
            'ID_PROYEK' => $id,
            'KODE_PROYEK' => $request->KODE_PROYEK,
            'NAMA_PROYEK' => $request->NAMA_PROYEK
        ])->delete();
       
        return redirect()->back()->with('success','Data rencana berhasil dihapus.');
    }

    public function exportexcel()
	{
		return Excel::download(new ProyekExport, 'S-Curve.xlsx');
	}
}
