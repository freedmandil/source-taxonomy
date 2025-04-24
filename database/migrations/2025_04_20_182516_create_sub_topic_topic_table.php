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
        Schema::create('sub_topic_topic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_topic_id')->constrained('sub_topics');
            $table->foreignId('topic_id')->constrained('topics');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_topic_topic');
    }
};
