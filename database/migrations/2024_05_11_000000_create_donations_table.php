<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2); // Total amount including tip and fees
            $table->decimal('base_amount', 10, 2); // Original donation amount
            $table->decimal('tip_percentage', 5, 2)->default(12.00); // Tip percentage
            $table->decimal('processing_fee', 10, 2)->nullable(); // Processing fee amount
            $table->string('currency', 3)->default('USD');
            $table->string('donor_name');
            $table->string('donor_email');
            $table->boolean('anonymous')->default(false);
            $table->boolean('allow_contact')->default(false);
            $table->string('status');
            $table->enum('payment_method', ['amex', 'card', 'bank', 'cash'])->nullable();
            $table->string('transaction_id')->unique()->nullable();
            $table->enum('donation_type', ['one-time', 'monthly'])->default('one-time');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
