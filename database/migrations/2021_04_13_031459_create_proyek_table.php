<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->integer('ID_PROYEK',true);
            $table->string('KODE_PROYEK', 10)->unique();
            $table->string('NAMA_PROYEK', 200);
            $table->date('START_PROYEK');
            $table->date('END_PROYEK');
            $table->smallInteger('STATUS');
            $table->timestamp('LAST_UPDATE')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyek');
    }
}
