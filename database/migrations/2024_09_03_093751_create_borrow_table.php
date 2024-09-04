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
        Schema::create('borrow', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_id');
            $table->unsignedBigInteger('book_id');
            $table->date('reserve_date');
            $table->date('due_date');
            $table->integer('book_return')->default(0)->comment('0 for no return and 1 for book returned');
            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors');
            $table->foreign('book_id')
                ->references('id')
                ->on('books');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow');
    }
};
