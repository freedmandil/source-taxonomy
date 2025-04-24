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
        Schema::create('text_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('text_id')->constrained('texts');
            $table->foreignId('taxonomy_id')->constrained('taxonomy');
            $table->string('text_value');
            $table->integer('numeric_value')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_references');
    }
};
