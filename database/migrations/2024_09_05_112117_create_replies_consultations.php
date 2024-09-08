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
        Schema::create('replies_consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id'); // معرف الاستشارة
            $table->unsignedBigInteger('user_id'); // معرف المستخدم
            $table->text('reply'); // نص الرد
            $table->string('file')->nullable(); // مرفق اختياري
            $table->timestamps();
            
            // تعيين المفاتيح الخارجية
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies_consultations');
    }
};
