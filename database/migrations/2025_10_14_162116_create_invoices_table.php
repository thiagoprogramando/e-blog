<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('value', 10, 2)->default(0);
            $table->string('payment_token')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('payment_url')->nullable();
            $table->date('payment_due_date')->nullable();
            $table->json('payment_split')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('invoices');
    }
};
