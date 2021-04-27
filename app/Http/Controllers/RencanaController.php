<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Progress;
use App\Models\Tipe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use DB;
// use \stdClass;

class RencanaController extends Controller
{
    public function index(){
        $proyek = Proyek::all();
        return view('admin.rencana_index',compact('proyek'));
    }

    public function show($id){

        $progress = Proyek::select('proyek.KODE_PROYEK', 'p1.TANGGAL', DB::raw('COALESCE(p1.VALUE,"-") AS PV'),  DB::raw('COALESCE(p2.VALUE,"-") AS Rencana'))
        ->join('progress as p1', 'p1.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->join('progress as p2', 'p2.KODE_PROYEK', 'proyek.KODE_PROYEK')
        ->where(['proyek.KODE_PROYEK' => $id, 'p1.ID_TIPE' => 1, 'p2.ID_TIPE' => 4, "p2.TANGGAL" => DB::raw("(DATE_FORMAT(p1.TANGGAL,'%Y-%m-%d'))"),])
        ->orderByDesc('p1.TANGGAL')
        ->get();
        $kode_proyek = $id;
        $nama_proyek = Proyek::where('KODE_PROYEK', $id)->value('NAMA_PROYEK');
        $start_proyek = Proyek::where('KODE_PROYEK', $id)->value('START_PROYEK');
        $end_proyek = Proyek::where('KODE_PROYEK', $id)->value('END_PROYEK');
        
        $current_year = date('Y');
        $jml_rencana_this_month  = Progress::all()->count();
        $jml_rencana_last_month  = Progress::whereMonth(
            'tanggal', '=', Carbon::now()->subMonth()->month
        )->whereYear('TANGGAL', date('Y'))->count();

        $current_year = date('Y');

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
                            $data[$a][$i][$j]->NAMA = date("M 'y",strtotime($start_proyek_tahun+$i."-".$j."-01"));
                        }
                    }
                    elseif( $i == ($jml_tahun-1)){
                        for($j=1;$j<=$end_proyek_bulan;$j++){
                            $data[$a][$i][$j] = new \stdClass();
                            $data[$a][$i][$j]->VALUE = Progress::whereMonth('TANGGAL',$j)->whereYear('TANGGAL',($start_proyek_tahun+$i))->where(['ID_TIPE' => $a,'KODE_PROYEK' =>$id])->value('VALUE');
                            $data[$a][$i][$j]->NAMA = date("M 'y",strtotime($start_proyek_tahun+$i."-".$j."-01"));
                        }
                    }
                }
            }
        }

        return view('admin.rencana',compact('progress', 'current_year', 'jml_rencana_this_month', 'jml_rencana_last_month', 'nama_proyek', 'kode_proyek', 'start_proyek', 'end_proyek', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bln' => 'required',
            'thn' => 'required'
        ]);

        $request->bln = ($request->bln < 10) ? "0".$request->bln : $request->bln;
        $date= $request->thn."-".$request->bln."-01";

        if(Progress::where(['TANGGAL' => $date,'KODE_PROYEK' => $request->KODE_PROYEK])->exists()){
            throw ValidationException::withMessages(['messages' => 'Sudah terdapat rencana pada bulan dan tahun tersebut.']);
        }
        else{
        // Insert PV
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 1,
            'VALUE' => $request->PV_VALUE,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
        // Insert rencana
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 4,
            'VALUE' => $request->RENCANA_VALUE,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
         // Insert EV
         Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 2,
            'VALUE' => null,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
         // Insert AC
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 3,
            'VALUE' => null,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
        // Insert REALISASI
        Progress::insert([
            'TANGGAL' =>$date,
            'ID_TIPE' => 5,
            'VALUE' => null,
            'KODE_PROYEK' => $request->KODE_PROYEK
        ]);
        }
        Proyek::where('KODE_PROYEK',$request->KODE_PROYEK)->update([
            'LAST_UPDATE' => now()
        ]);
        Progress::where('TANGGAL',$request->TANGGAL)->update([
            'LAST_UPDATE' => now()
        ]);

        return redirect()->back()->with('success','Data rencana berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'PV_VALUE_EDIT' => 'required',
        //     'RENCANA_EDIT' => 'required'
        // ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '1')->update([
            'VALUE' => $request->PV_VALUE_EDIT,
        ]);

        Progress::where('KODE_PROYEK',$request->KODE_PROYEK)->where('TANGGAL', $request->TANGGAL_EDIT)
        ->where('ID_TIPE', '4')->update([
            'VALUE' => $request->RENCANA_VALUE_EDIT,
        ]);
        Proyek::where('KODE_PROYEK',$request->KODE_PROYEK)->update([
            'LAST_UPDATE' => now()
        ]);
        return redirect()->back()->with('success','Data rencana berhasil diupdate.');
    }

    public function destroy($id, Request $request)
    {
      Progress::where([
          'KODE_PROYEK' => $id,
          'TANGGAL' => $request->TANGGAL_DELETE
      ])->delete();
       
        return redirect()->back()->with('success','Data rencana berhasil dihapus.');
    }
}
