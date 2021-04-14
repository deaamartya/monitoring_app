<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Proyek;
use App\Models\Tipe;

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
        ->orderByDesc('TANGGAL')
        ->get();
        $tipe = Tipe::all();
        $tgl_progress = Progress::where('KODE_PROYEK', $id)
        // ->whereNull('EV_VALUE')
        ->orderByDesc('TANGGAL')
        ->get();
        $kode_proyek = $id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        // SELECT p.KODE_PROYEK, p1.TANGGAL, COALESCE(p1.VALUE,"-") as 'PV', COALESCE(p2.VALUE,"-") as 'EV', COALESCE(p3.VALUE,"-") as 'AC', COALESCE(p4.VALUE,"-") as 'Rencana', COALESCE(p5.VALUE,"-") as 'Realisasi'
        // FROM `proyek` p 
        // JOIN progress p1 
        // ON p1.KODE_PROYEK = p.KODE_PROYEK
        // JOIN progress p2 
        // ON p2.KODE_PROYEK = p.KODE_PROYEK
        // JOIN progress p3 
        // ON p3.KODE_PROYEK = p.KODE_PROYEK
        // JOIN progress p4 
        // ON p4.KODE_PROYEK = p.KODE_PROYEK
        // JOIN progress p5 
        // ON p5.KODE_PROYEK = p.KODE_PROYEK
        // WHERE p1.ID_TIPE = '1' AND p2.ID_TIPE = "2" AND p3.ID_TIPE = "3" AND p4.ID_TIPE = "4" AND p5.ID_TIPE = "5" AND p2.TANGGAL = p1.TANGGAL AND p3.TANGGAL = p1.TANGGAL AND p4.TANGGAL = p1.TANGGAL AND p5.TANGGAL = p1.TANGGAL AND p.KODE_PROYEK = ""
        return view('admin.realisasi',compact('progress', 'nama_proyek', 'kode_proyek', 'tgl_progress','tipe'));
    }

    public function getRencana(Request $req)
    {
        $pv_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '1']])->value('VALUE');
        $rencana_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '4']])->value('VALUE');
        return response()->json(['pv_val'=>$pv_val, 'rencana_val'=>$rencana_val]);
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
