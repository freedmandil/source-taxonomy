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
        // migration for publishers table
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name_english');
            $table->string('name_hebrew');
            $table->json('name_languages')->nullable();
            $table->json('meta')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
