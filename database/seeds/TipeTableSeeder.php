<?php

use Illuminate\Database\Seeder;

class TipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tipe')->delete();
        \DB::table('tipe')->insert([
            'ID_TIPE' => '1',
            'NAMA_TIPE' => 'PV',
        ]);
        \DB::table('tipe')->insert([
            'ID_TIPE' => '2',
            'NAMA_TIPE' => 'EV',
        ]);
        \DB::table('tipe')->insert([
            'ID_TIPE' => '3',
            'NAMA_TIPE' => 'AC',
        ]);
        \DB::table('tipe')->insert([
            'ID_TIPE' => '4',
            'NAMA_TIPE' => 'Rencana',
        ]);
        \DB::table('tipe')->insert([
            'ID_TIPE' => '5',
            'NAMA_TIPE' => 'Realisasi',
        ]);
    }
}
