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
        Schema::create('bukti_pengajuan_prasejahtera', function (Blueprint $table) {
            $table->bigInteger("add")->unsigned();
            $table->string("nama_bukti", 100);
            $table->timestamps();

            $table->foreign('add')->references('id')->on('pengajuanprasejahtera')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pengajuan_prasejahtera');
    }
};