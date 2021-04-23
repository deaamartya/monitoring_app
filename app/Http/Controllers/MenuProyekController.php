<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Exports\ProyekExport;
use Carbon\Carbon;
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
            'END_PROYEK' => 'required',
            'STATUS' => 'required'
        ]);

        Proyek::insert([
            'KODE_PROYEK' => $request->KODE_PROYEK,
            'NAMA_PROYEK' => $request->NAMA_PROYEK,
            'START_PROYEK' => date('Y-m-d',strtotime($request->START_PROYEK)),
            'END_PROYEK' => date('Y-m-d',strtotime($request->END_PROYEK)),
            'STATUS' => $request->STATUS
        ]);
        
        return redirect()->back()->with('message','Success');
    }

    public function exportexcel()
	{
		return Excel::download(new ProyekExport, 'S-Curve.xlsx');
	}
}
