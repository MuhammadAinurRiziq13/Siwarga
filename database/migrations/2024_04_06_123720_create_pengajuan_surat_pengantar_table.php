<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuansuratpengantar', function (Blueprint $table) {
            $table->id('id',3);
            $table->string('nama', 30);
            $table->string('tempat_lahir',30);$table->date('tanggal_lahir');
            $table->string('NIK',16);
            $table->string('pekerjaan',30);
            $table->string('pendidikan',15);
            $table->string('no_hp',15);
            $table->string('agama',10);
            $table->string('keperluan',50);
            $table->string('status',8);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('NIK')->references('NIK')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuansuratpengantar');
    }
};
