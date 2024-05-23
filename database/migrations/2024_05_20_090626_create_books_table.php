<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->unsignedBigInteger('book_category_id');
        $table->string('section');
        $table->decimal('price', 8, 2);
        $table->string('image');
        $table->timestamps();
        
    });

    Schema::table('books', function (Blueprint $table) {
        $table->foreign('book_category_id')
              ->references('id')
              ->on('book_categories')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
