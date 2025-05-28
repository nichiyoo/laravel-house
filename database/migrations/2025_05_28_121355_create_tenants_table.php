<?php

use App\Models\User;
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
    Schema::create('tenants', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
      $table->boolean('completed')->default(false);
      $table->string('address');
      $table->decimal('latitude', 10, 6);
      $table->decimal('longitude', 10, 6);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tenants');
  }
};
