<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->date('TANGGAL');
            $table->string('KODE_PROYEK', 10)->index('FK_MEMILIKI');
            $table->float('PV_VALUE', 15)->nullable();
            $table->float('EV_VALUE', 15)->nullable();
            $table->float('AC_VALUE', 15)->nullable();
            $table->integer('RENCANA')->nullable();
            $table->integer('REALISASI')->nullable();
            $table->primary(['TANGGAL', 'KODE_PROYEK']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress');
    }
}
