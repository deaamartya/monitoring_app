<?php

use Illuminate\Database\Seeder;

class ProgressTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('progress')->delete();
        $progres[] = [
            'TANGGAL' => date('Y-m-d'),
            'KODE_PROYEK' => "ABC45678",
            'PV_VALUE' => "9227",
            'EV_VALUE' => NULL,
            'AC_VALUE' => NULL,
            'RENCANA' => "80",
            'REALISASI' => NULL,
        ];
        DB::table('progress')->insert($progres);
        
        
    }
}