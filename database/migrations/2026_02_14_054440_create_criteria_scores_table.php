<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('criteria_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaluation_id')
                  ->constrained('evaluations')
                  ->onDelete('cascade');

            $table->foreignId('criteria_id')
                  ->constrained('evaluation_criteria')
                  ->onDelete('cascade');

            $table->integer('number_rating');
            $table->text('remarks')->nullable(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteria_scores');
    }
};
