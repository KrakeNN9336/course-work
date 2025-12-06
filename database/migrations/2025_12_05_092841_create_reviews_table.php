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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Зв'язок з товаром (видаляємо відгуки, якщо товар видалено)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // Зв'язок з користувачем (видаляємо відгуки, якщо юзер видалений)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->integer('rating'); // Оцінка 1-5
            $table->text('comment')->nullable(); // Текст відгуку
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};