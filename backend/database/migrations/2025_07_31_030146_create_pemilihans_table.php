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
        Schema::create('pemilihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kandidat_id")->nullable(false)->constrained("kandidats")->cascadeOnDelete();
            $table->foreignId("pemilih_id")->nullable(false)->constrained("masyarakats")->cascadeOnDelete();
            $table->foreignId("periode_id")->nullable(false)->constrained("periodes")->cascadeOnDelete();
            $table->timestamp("pemilihan_pada")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilihans');
    }
};
