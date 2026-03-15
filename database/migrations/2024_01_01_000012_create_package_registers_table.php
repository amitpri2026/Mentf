<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // mentee
            $table->string('status')->default('pending'); // pending, active, completed, cancelled
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_status')->default('pending'); // pending, paid, refunded
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_registers');
    }
};
