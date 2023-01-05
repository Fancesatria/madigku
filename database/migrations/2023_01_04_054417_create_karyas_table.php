<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idkategori');
            $table->bigInteger('idpengguna');
            $table->string('judul');
            $table->string('keterangan');
            $table->string('gambar')->nullable();
            $table->date('tgl_upload');
            $table->string('status')->default('Menunggu Verifikasi');
            $table->string('like')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyas');
    }
}
