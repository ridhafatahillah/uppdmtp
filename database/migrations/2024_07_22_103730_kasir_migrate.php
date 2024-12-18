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
        Schema::create("kasir", function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->date('tanggal')->nullable();
            $table->bigInteger('no_notice');
            $table->string('no_polisi')->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('total_pajak')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('baru')->nullable();
            $table->foreignId('users_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasir');
    }
};
