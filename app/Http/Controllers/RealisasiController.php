<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Proyek;
use App\Models\Tipe;
use Illuminate\Support\Carbon;
use DB;

class RealisasiController extends Controller
{
    public function index(){
        $proyek = Proyek::all();
        return view('admin.realisasi_index',compact('proyek'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $progress = Proyek::select('proyek.KODE_PROYEK', 'p1.TANGGAL', DB::raw('COALESCE(p1.VALUE,"-") AS PV'), 
        DB::raw('COALESCE(p2.VALUE,"-") AS EV'), DB::raw('COALESCE(p3.VALUE,"-") AS AC'), DB::raw('COALESCE(p4.VALUE,"-") AS Rencana'), DB::raw('COALESCE(p5.VALUE,"-") AS Realisasi'))
        ->join('progress as p1', 'p1.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->join('progress as p2', 'p2.KODE_PROYEK','proyek.KODE_PROYEK')
        ->join('progress as p3', 'p3.KODE_PROYEK','proyek.KODE_PROYEK')
        ->join('progress as p4', 'p4.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->join('progress as p5', 'p5.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->where(['proyek.KODE_PROYEK' => $id, 'p1.ID_TIPE' => 1, 'p2.ID_TIPE' => 2, 'p3.ID_TIPE'  => 3,'p4.ID_TIPE' =>4, 'p5.ID_TIPE'  =>5,
            "p2.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))"), "p3.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))"),"p4.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))"),"p5.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))")])
        ->orderByDesc('p1.TANGGAL')
        ->get();
        $tipe = Tipe::all();
        $tgl_progress = Progress::where('KODE_PROYEK', $id)
        ->orderByDesc('TANGGAL')
        ->get();
        $kode_proyek = $id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');

        $progress2=Progress::all();
        $jml_realisasi_this_month  = Proyek::all()->count();
        $jml_realisasi_last_month  = Proyek::whereMonth(
            'START_PROYEK', '=', Carbon::now()->subMonth()->month
        )->whereYear('START_PROYEK', date('Y'))->count();

        $current_year = date('Y');
        
        $start_proyek = Proyek::where('KODE_PROYEK', $id)->value('START_PROYEK');
        $end_proyek = Proyek::where('KODE_PROYEK', $id)->value('END_PROYEK');
        $start_proyek_tahun = date('Y',strtotime($start_proyek));
        $end_proyek_tahun = date('Y',strtotime($end_proyek));
        $start_proyek_bulan = intval(date('m',strtotime($start_proyek)));
        $end_proyek_bulan = intval(date('m',strtotime($end_proyek)));

        $jml_tahun = $end_proyek_tahun - $start_proyek_tahun + 1;

        for($a=1;$a<=5;$a++){
            for($i=0;$i<$jml_tahun;$i++){
                if($jml_tahun == 1){
                    for($j=$start_proyek_bulan;$j<=$end_proyek_bulan;$j++){
                        $data[$a][$i][$j] = new \stdClass();
                        $data[$a][$i][$j]->VALUE = Progress::whereMonth('TANGGAL',$j)->whereYear('TANGGAL',($start_proyek_tahun+$i))->where(['ID_TIPE' => $a,'KODE_PROYEK' =>$id])->value('VALUE');
                        $data[$a][$i][$j]->NAMA = date("M 'y",strtotime($start_proyek_tahun+$i."-".$j."-01"));
                    }
                }
                elseif($jml_tahun > 1){
                    if($i == 0){
                        for($j=$start_proyek_bulan;$j<=12;$j++){
                            $data[$a][$i][$j] = new \stdClass();
                            $data[$a][$i][$j]->VALUE = Progress::whereMonth('TANGGAL',$j)->whereYear('TANGGAL',($start_proyek_tahun+$i))->where(['ID_TIPE' => $a,'KODE_PROYEK' =>$id])->value('VALUE');
                            $data[$a][$i][$j]->NAMA = date("M 'y",strtotime($start_proyek_tahun+$i."-".$j."-01"));
                        }
                    }
                    elseif($i != 0 && ($i != ($jml_tahun-1))){
                        for($j=1;$j<=12;$j++){
                            $data[$a][$i][$j] = new \stdClass();
                            $data[$a][$i][$j]->VALUE = Progress::whereMonth('TANGGAL',$j)->whereYear('TANGGAL',($start_proyek_tahun+$i))->where(['ID_TIPE' => $a,'KODE_PROYEK' =>$id])->value('VALUE');
                            $data[$a][$i][$j]->NAMA = date("M y",strtotime($start_proyek_tahun+$i."-".$j."-01"));
                        }
                    }
                    elseif( $i == ($jml_tahun-1)){
                        for($j=1;$j<=$end_proyek_bulan;$j++){
                            $data[$a][$i][$j] = new \stdClass();
                            $data[$a][$i][$j]->VALUE = Progress::whereMonth('TANGGAL',$j)->whereYear('TANGGAL',($start_proyek_tahun+$i))->where(['ID_TIPE' => $a,'KODE_PROYEK' =>$id])->value('VALUE');
                            $data[$a][$i][$j]->NAMA = date("M y",strtotime($start_proyek_tahun+$i."-".$j."-01"));
                        }
                    }
                }
            }
        }


        return view('admin.realisasi',compact('progress', 'nama_proyek', 'kode_proyek', 'tgl_progress','tipe', 'progress2', 'current_year', 'jml_realisasi_this_month', 'jml_realisasi_last_month', 'data'));
    }

    public function getRencana(Request $req)
    {
        $pv_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '1']])->value('VALUE');
        $rencana_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '4']])->value('VALUE');
        $ev_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '2']])->value('VALUE');
        $ac_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '3']])->value('VALUE');
        $realisasi_val = Progress::where([['TANGGAL', $req->tgl], ['KODE_PROYEK', $req->kd_proyek], ['ID_TIPE', '5']])->value('VALUE');
        if($ev_val != null || $ac_val != null || $realisasi_val != null){
            $pesan_error = "Data sudah ada pada bulan dan tahun yang sama. Pilih bulan dan tahun lainnya.";
        }else{
            $pesan_error = "";
        }
        return response()->json(['pv_val'=>$pv_val, 'rencana_val'=>$rencana_val, 'pesan_error'=>$pesan_error]);
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
            'RENCANA_VALUE' => 'required'
        ]);
        
        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL)
        ->where('ID_TIPE', '2')->update([
            'VALUE' => $request->EV_VALUE,
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL)
        ->where('ID_TIPE', '3')->update([
            'VALUE' => $request->AC_VALUE,
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL)
        ->where('ID_TIPE', '5')->update([
            'VALUE' => $request->REALISASI_VALUE,
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
        // $request->validate([
        //     'EV_VALUE_EDIT' => 'required',
        //     'AC_VALUE_EDIT' => 'required',
        //     'REALISASI_EDIT' => 'required'
        // ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '2')->update([
            'VALUE' => $request->EV_VALUE_EDIT,
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '3')->update([
            'VALUE' => $request->AC_VALUE_EDIT,
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '5')->update([
            'VALUE' => $request->REALISASI_VALUE_EDIT,
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
        
        Progress::where('KODE_PROYEK',$id)->where('TANGGAL', $request->TANGGAL_DELETE)
        ->where('ID_TIPE', '2')->update([
            'VALUE' => NULL,
        ]);

        Progress::where('KODE_PROYEK',$id)->where('TANGGAL', $request->TANGGAL_DELETE)
        ->where('ID_TIPE', '3')->update([
            'VALUE' => NULL,
        ]);

        Progress::where('KODE_PROYEK',$id)->where('TANGGAL', $request->TANGGAL_DELETE)
        ->where('ID_TIPE', '5')->update([
            'VALUE' => NULL,
        ]);

        return redirect()->back()->with('success','Data realisasi berhasil dihapus.');
    }
}
