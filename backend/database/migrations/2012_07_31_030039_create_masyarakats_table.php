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
        Schema::create('masyarakats', function (Blueprint $table) {
            $table->id();
            $table->string("nik")->unique()->nullable(false);
            $table->string("nama_lengkap")->nullable(false);
            $table->string("alamat");
            $table->date("tanggal_lahir");
            $table->string("tempat_lahir");
            $table->string("agama");
            $table->enum('status_kawin', ['lajang','menikah'])->default('menikah');
            $table->string("foto")->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakats');
    }
};
