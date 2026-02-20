<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('digital_approvals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaluation_id')
                  ->constrained('evaluations')
                  ->onDelete('cascade');

            $table->string('full_name');
            $table->string('designation');
            $table->string('role'); // Prepared By, Approved By, Noted By
            $table->string('image'); // signature file path

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_approvals');
    }
};
