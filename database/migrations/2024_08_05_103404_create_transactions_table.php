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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('result');
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('store_id')->nullable();
            $table->string('our_ref')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('custom_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
