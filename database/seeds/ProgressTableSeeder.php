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
            'TANGGAL' => '2021-01-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '1',
            'VALUE' => '9000',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-01-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '2',
            'VALUE' => '8000',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-01-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '3',
            'VALUE' => '7000',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-01-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '4',
            'VALUE' => '60.54',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-01-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '5',
            'VALUE' => '10.89',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-02-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '1',
            'VALUE' => '1000',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-02-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '2',
            'VALUE' => '2000',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-02-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '3',
            'VALUE' => '3000',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-02-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '4',
            'VALUE' => '10.30',
        ]);
        \DB::table('progress')->insert([
            'TANGGAL' => '2021-02-01',
            'KODE_PROYEK' => "ABC45678",
            'ID_TIPE' => '5',
            'VALUE' => '20.30',
        ]);
    }
}