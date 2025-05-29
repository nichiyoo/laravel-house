<?php

use App\Enums\MethodType;
use App\Enums\StatusType;
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
    $methods = array_map(fn(MethodType $method) => $method->value, MethodType::cases());
    $statuses = array_map(fn(StatusType $status) => $status->value, StatusType::cases());

    Schema::create('tenant_properties', function (Blueprint $table) use ($methods, $statuses) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Tenant::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Property::class)->constrained()->cascadeOnDelete();
      $table->date('start');
      $table->integer('duration');
      $table->integer('rating')->nullable();
      $table->string('review')->nullable();
      $table->boolean('is_reviewed')->default(false);
      $table->enum('method', $methods)->default(MethodType::CASH->value);
      $table->enum('status', $statuses)->default(StatusType::PENDING->value);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tenant_properties');
  }
};
