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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('book_year_id');
            $table->unsignedBigInteger('book_lang_id');
            $table->integer('book_stock');
            $table->string('book_image_url');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->foreign('book_year_id')
                ->references('id')
                ->on('book_years');
            $table->foreign('book_lang_id')
                ->references('id')
                ->on('book_languages');
            $table->timestamps();
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
