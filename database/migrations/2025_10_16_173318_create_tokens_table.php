<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->unique();
            $table->foreignId('company_id')->constrained('users')->nullOnDelete(); // Deleta se a user for deletada
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('ip')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tokens');
    }
};
