<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('company_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject');
            $table->text('content');
            $table->json('attachments')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent'])->default('draft');
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newsletter_deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('newsletter_id')->constrained('newsletters')->cascadeOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->string('email');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('message')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('newsletter_deliveries');
        Schema::dropIfExists('newsletters');
    }
};
