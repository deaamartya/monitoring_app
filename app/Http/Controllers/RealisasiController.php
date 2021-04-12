<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Proyek;

class RealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $progress = Progress::where('KODE_PROYEK', $id)
        ->whereNotNull('EV_VALUE')
        ->orWhereNotNull('AC_VALUE')
        ->orWhereNotNull('REALISASI')
        ->orderByDesc('TANGGAL')
        ->get();
        $tgl_progress = Progress::where('KODE_PROYEK', $id)
        ->whereNull('EV_VALUE')
        ->orWhereNull('AC_VALUE')
        ->orWhereNull('REALISASI')
        ->orderByDesc('TANGGAL')
        ->get();
        $kode_proyek =$id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        return view('admin.realisasi',compact('progress', 'nama_proyek', 'kode_proyek', 'tgl_progress'));
    }

    public function getRencana(Request $req)
    {
        $pv_val = Progress::where('TANGGAL', $req->key)->value('PV_VALUE');
        return response()->json(['pv_val'=>$pv_val]);
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
            'EV_VALUE' => 'required',
            'AC_VALUE' => 'required',
            'REALISASI' => 'required'
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL)->update([
            'EV_VALUE' => $request->EV_VALUE,
            'AC_VALUE' => $request->AC_VALUE,
            'REALISASI' => $request->REALISASI
        ]);
        
        return redirect()->back()->with('success','Data realisasi berhasil ditambahkan.');
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
            'EV_VALUE_EDIT' => 'required',
            'AC_VALUE_EDIT' => 'required',
            'REALISASI_EDIT' => 'required'
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)->update([
            'EV_VALUE' => $request->EV_VALUE_EDIT,
            'AC_VALUE' => $request->AC_VALUE_EDIT,
            'REALISASI' => $request->REALISASI_EDIT
        ]);

        return redirect()->back()->with('success','Data realisasi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        Progress::where('KODE_PROYEK',$id)->where('TANGGAL', $request->TANGGAL_DELETE)->update([
            'EV_VALUE' => NULL,
            'AC_VALUE' => NULL,
            'REALISASI' => NULL
        ]);

        return redirect()->back()->with('success','Data realisasi berhasil dihapus.');
    }
}
