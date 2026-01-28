<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('donation_programs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();

      $table->string('title');
      $table->text('summary')->nullable();
      $table->longText('description');

      $table->string('category')->nullable(); // contoh: Pendidikan, Kesehatan, dll
      $table->unsignedBigInteger('target_amount');
      $table->date('end_date')->nullable();

      $table->string('cover_image_path')->nullable();

      $table->enum('status', ['draft', 'published'])->default('draft');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('donation_programs');
  }
};
