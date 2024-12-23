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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['table', 'sirup', 'kapsul']);
            $table->string('name');
            $table->integer('price');
            $table->integer('stock');   
            $table->timestamps(); // akan menghasilkan 2 column : created_ad (auto terisi tgl pembuatan),
            // update_at (terisi tgl data di ubah) 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
