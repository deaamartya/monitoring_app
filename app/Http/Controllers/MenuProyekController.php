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

    public function exportexcel()
	{
		return Excel::download(new ProyekExport, 'S_Curve.xlsx');
	}
}
