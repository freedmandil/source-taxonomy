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
        // migration for sefarim table
        Schema::create('sefarim', function (Blueprint $table) {
            $table->id();
            $table->string('hebrew_name');
            $table->string('english_name');
            $table->json('other_names')->nullable();
            $table->foreignId('publisher_id')->nullable()->constrained('publishers');
            $table->integer('edition')->nullable();
            $table->integer('publication_year')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sefarim');
    }
};
