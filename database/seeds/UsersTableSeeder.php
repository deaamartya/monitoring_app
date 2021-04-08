<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        \DB::table('users')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'NAMA_LENGKAP' => 'Admin'
        ]);
        
        
    }
}