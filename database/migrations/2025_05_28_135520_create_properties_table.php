<?php

use App\Enums\IntervalType;
use App\Enums\VerificationType;
use App\Models\Owner;
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
    $intervals = array_map(fn(IntervalType $interval) => $interval->value, IntervalType::cases());
    $verifications = array_map(fn(VerificationType $verification) => $verification->value, VerificationType::cases());

    Schema::create('properties', function (Blueprint $table) use ($intervals, $verifications) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Owner::class)->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->string('city');
      $table->string('region');
      $table->string('zipcode');
      $table->string('address');
      $table->integer('price')->default(0);
      $table->integer('capacity')->default(0);
      $table->enum('interval', $intervals)->default(IntervalType::MONTHLY->value);
      $table->enum('verification', $verifications)->default(VerificationType::UNVERIFIED->value);
      $table->text('description');
      $table->decimal('latitude', 10, 6);
      $table->decimal('longitude', 10, 6);
      $table->string('backdrop')->nullable();
      $table->json('images')->nullable();
      $table->json('amenities')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('properties');
  }
};
