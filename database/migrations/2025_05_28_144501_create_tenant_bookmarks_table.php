<?php

use App\Models\Property;
use App\Models\Tenant;
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
    Schema::create('tenant_bookmarks', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Tenant::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Property::class)->constrained()->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tenant_bookmarks');
  }
};
