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
            $table->unsignedBigInteger('publisher_id');
            $table->string('title');
            $table->string('author'); // 筆者は複数いるパターンがあるので、author_id は使わない
            $table->string('isbn')->unique();
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price')->nullable();
            $table->string('image_url')->nullable();
            $table->dateTime('published_date');
            $table->timestamps();

            // 出版社idに外部キー制約を付与 出版社テーブルがまだないのでコメントアウト
            // $table->foreign('publisher_id')->references('id')->on('publishers');
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
