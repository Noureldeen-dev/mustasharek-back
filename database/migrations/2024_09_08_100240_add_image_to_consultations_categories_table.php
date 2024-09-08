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
        Schema::table('consultations_categories', function (Blueprint $table) {
            $table->string('image')->nullable(); // إضافة حقل الصورة
        });
    }

    public function down(): void
    {
        Schema::table('consultations_categories', function (Blueprint $table) {
            $table->dropColumn('image'); // حذف الحقل في حالة التراجع
        });
    }
};
