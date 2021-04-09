<?php

use Illuminate\Database\Seeder;

class ProyekTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('proyek')->delete();
        
        $proyek[] = [
            'KODE_PROYEK' => "ABC45678",
            'NAMA_PROYEK' => "contoh proyek",
            'START_PROYEK' => "2021-01-01",
            'END_PROYEK' => "2021-03-31",
            'STATUS' => "0",
            'LAST_UPDATE' => "2021-04-09 08:40:51",
        ];
        DB::table('proyek')->insert($proyek);
        
    }
}