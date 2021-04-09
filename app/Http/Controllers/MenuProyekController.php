<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use DB;
use App\Models\Proyek;
use Maatwebsite\Excel\Facades\Excel;


class MenuProyekController extends Controller
{
    public function index(){
        $proyek = Proyek::all();
        return view('admin.menuproyek',compact('proyek'));
    }

    public function exportexcel()
	{
		return Excel::download(new SiswaExport, 'S_Curve.xlsx');
	}
}
