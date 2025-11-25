<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('review_body');
            $table->string('rejection_reason')->nullable();
            $table->float('review_rating')->nullable();
            $table->boolean('approved')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
};
