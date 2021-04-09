<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;

class RealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $progress = Progress::where('KODE_PROYEK', $id)->get();
        return view('admin.realisasi',compact('progress'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'TANGGAL' => 'required',
            'PV_VALUE' => 'required',
            'EV_VALUE' => 'required',
            'AC_VALUE' => 'required',
            'REALISASI' => 'required'
        ]);

        Progress::insert([
            'TANGGAL' => $request->TANGGAL,
            'PV_VALUE' => $request->PV_VALUE,
            'EV_VALUE' => $request->EV_VALUE,
            'AC_VALUE' => $request->AC_VALUE,
            'REALISASI' => $request->REALISASI
        ]);
        
        return redirect('admin/realisasi')->with('success','Realisasi berhasil ditambahkan.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'TANGGAL' => 'required',
            'PV_VALUE' => 'required',
            'EV_VALUE' => 'required',
            'AC_VALUE' => 'required',
            'REALISASI' => 'required'
        ]);

        Progress::find($id)->update([
            'TANGGAL' => $request->TANGGAL,
            'PV_VALUE' => $request->PV_VALUE,
            'EV_VALUE' => $request->EV_VALUE,
            'AC_VALUE' => $request->AC_VALUE,
            'REALISASI' => $request->REALISASI
        ]);

        return redirect('admin/realisasi')->with('success','Realisasi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Progress::find($id)->update([
            'EV_VALUE' => null,
            'AC_VALUE' => null,
            'REALISASI' => null
        ]);

        return redirect('admin/realisasi')->with('success','Realisasi berhasil dihapus.');
    }
}
