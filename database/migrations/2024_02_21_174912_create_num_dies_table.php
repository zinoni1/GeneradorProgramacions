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
        Schema::create('num_dies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('dia');
            $table->integer('num_sessio');
            $table->foreignId('cicle_id')
                ->references('id')
                ->on('cicles')
                ->onDelete('cascade');
                $table->foreignId('modul_id')
                ->references('id')
                ->on('moduls')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('num_dies');
    }
};