<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;


class MenuProyekController extends Controller
{
    $menuproyek=MenuProyek::all();
    return view('admin.menuproyek',compact('menuproyek'));
}
