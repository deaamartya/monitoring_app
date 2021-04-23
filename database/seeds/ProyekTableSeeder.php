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
        
        \DB::table('proyek')->insert([
            'KODE_PROYEK' => "ABC45678",
            'NAMA_PROYEK' => "Kapal Niaga I",
            'START_PROYEK' => "2021-01-01",
            'END_PROYEK' => "2021-03-31",
            'STATUS' => "0",
            'LAST_UPDATE' => "2021-04-09 08:40:51",
            'CREATED_AT' => "2021-04-08 09:40:50",
        ]);

        \DB::table('proyek')->insert([
            'KODE_PROYEK' => "DEF1234",
            'NAMA_PROYEK' => "Kapal Selam I",
            'START_PROYEK' => "2021-04-01",
            'END_PROYEK' => "2022-05-31",
            'STATUS' => "0",
            'LAST_UPDATE' => "2021-04-09 08:40:51",
            'CREATED_AT' => "2021-04-08 10:40:50",
        ]);

        \DB::table('proyek')->insert([
            'KODE_PROYEK' => "KPW8973",
            'NAMA_PROYEK' => "Kapal Selam II",
            'START_PROYEK' => "2021-09-01",
            'END_PROYEK' => "2023-05-31",
            'STATUS' => "0",
            'LAST_UPDATE' => "2021-04-09 08:40:51",
            'CREATED_AT' => "2021-04-08 11:40:50",
        ]);
        
    }
}