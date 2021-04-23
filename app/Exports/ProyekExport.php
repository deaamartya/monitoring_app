<?php

namespace App\Exports;

use App\Models\Proyek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProyekExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sheet1';
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Proyek',
            'Nama Proyek',
            'Tanggal',
            'Tipe',
            'Value',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 12]],
            'A:F' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Proyek::select('proyek.ID_PROYEK as Nomor','proyek.KODE_PROYEK','proyek.NAMA_PROYEK','p.TANGGAL as Tanggal','t.NAMA_TIPE','p.VALUE as Value')->rightJoin('progress as p', 'p.KODE_PROYEK','proyek.KODE_PROYEK')->join('tipe as t','t.ID_TIPE','p.ID_TIPE')->orderBy('proyek.ID_PROYEK')->orderBy('p.TANGGAL')->orderBy('p.ID_TIPE')->get();
        $i=1;
        foreach($data as $d){
            $d->Nomor = $i;
            if(($d->NAMA_TIPE == "Rencana" || $d->NAMA_TIPE == "Realisasi") && $d->Value != ""){
                $d->Value = $d->Value."%";
            }
            $i++;
        }
        return $data;
    }
}
