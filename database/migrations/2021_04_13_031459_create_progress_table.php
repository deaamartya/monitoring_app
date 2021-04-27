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
            $table->integer('ID_TIPE')->index('FK_MEMILIKI3');
            $table->string('KODE_PROYEK', 10)->index('FK_MEMILIKI');
            $table->float('VALUE', 13, 2)->nullable();
            $table->dateTime('LAST_UPDATE');
            $table->primary(['TANGGAL', 'ID_TIPE', 'KODE_PROYEK']);
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
