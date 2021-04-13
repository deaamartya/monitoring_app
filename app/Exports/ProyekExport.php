<?php

namespace App\Exports;

use App\Models\Proyek;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProyekExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Proyek::all();
    }
}