<?php

namespace App\Exports;

use App\Models\Proyek;
use App\Models\Progress;
use App\Models\Tipe;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProyekExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $nama_proyek = Proyek::where('KODE_PROYEK')->value('NAMA_PROYEK');
        $proyek = Proyek::get('KODE_PROYEK','NAMA_PROYEK');
        $progress = Progress::get('TANGGAL','VALUE');
        $tipe = Tipe::where('ID_TIPE')->value('NAMA_TIPE');
        return view('admin.exportexcel', compact('proyek', 'progress', 'tipe') );
    }
}
