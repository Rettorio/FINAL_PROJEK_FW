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
        Schema::create('kandidats', function (Blueprint $table) {
            $table->id();
            $table->foreignId("periode_id")->nullable(false)->constrained("periodes")->cascadeOnDelete();
            $table->foreignId("calon")->nullable(false)->constrained("masyarakats")->cascadeOnDelete();
            $table->string("pendidikan_terakkhir");
            $table->string("pekerjaan_terakhir");
            $table->text("visi");
            $table->text("misi");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
