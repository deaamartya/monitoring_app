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
        \DB::table('progress')->insert([
            'TANGGAL' => date('Y-m-d'),
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '1',
            'VALUE' => '9845',
        ]);
        
        
    }
}