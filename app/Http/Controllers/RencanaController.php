<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use Illuminate\Http\Request;

class RencanaController extends Controller
{
    public function index(){
        $proyek = Proyek::all();
        return view('admin.rencana',compact('proyek'));
    }

    public function show($id)
    {
        $progress = Progress::find($id);
       
        return view('admin.rencana',compact('progress'));
    }
}
