<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('company_id')->constrained('users')->nullOnDelete();
            $table->string('title')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->string('smtp_host');
            $table->integer('smtp_port')->default(587);
            $table->enum('smtp_encryption', ['SSL', 'TLS'])->nullable();
            $table->string('smtp_username');
            $table->longText('smtp_password');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('emails');
    }
};
