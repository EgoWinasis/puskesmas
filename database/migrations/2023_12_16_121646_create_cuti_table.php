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
        Schema::create('cuti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->string('name');
            $table->string('email');
            $table->string('bagian');
            $table->string('pangkat');
            $table->string('jabatan');
            $table->string('jenis_cuti');
            $table->string('tgl_cuti');
            $table->string('alamat_cuti');
            $table->string('status');
            $table->string('approve_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
