<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type');
            $table->string('transaction_type')->default('sale');
            $table->string('status')->default('draft')->index();
            $table->string('country')->index();
            $table->string('city')->index();
            $table->string('area')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('salary_min', 15, 2)->nullable();
            $table->decimal('salary_max', 15, 2)->nullable();
            $table->string('currency', 8)->default('USD');
            $table->text('description');
            $table->string('contact_name')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->text('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('details')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};