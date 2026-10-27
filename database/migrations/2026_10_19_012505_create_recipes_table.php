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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kolom relasi user
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Kolom relasi kategori
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->json('ingredients'); // Format JSON untuk bahan-bahan
            $table->json('steps'); // Format JSON untuk langkah memasak
            $table->integer('cooking_time'); // Waktu masak dalam menit
            $table->integer('servings'); // Jumlah porsi
            $table->enum('difficulty', ['Mudah', 'Sedang', 'Sulit']);
            $table->text('image'); // URL foto resep
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
