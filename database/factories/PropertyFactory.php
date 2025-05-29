<?php

namespace Database\Factories;

use App\Enums\AmenityType;
use App\Enums\IntervalType;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $intervals = array_map(fn(IntervalType $interval) => $interval->value, IntervalType::cases());
    $amenities = array_map(fn(AmenityType $amenity) => $amenity->value, AmenityType::cases());

    $jakarta = (object) [
      'latitude' => (object) [
        'min' => -6.1751,
        'max' => -6.2087,
      ],
      'longitude' => (object) [
        'min' => 106.8272,
        'max' => 106.8992,
      ],
    ];

    return [
      'name' => 'Kos ' . fake()->streetName(),
      'city' => fake()->city(),
      'region' => fake()->state(),
      'zipcode' => fake()->postcode(),
      'address' => fake()->streetAddress(),
      'price' => fake()->numberBetween(5, 4) * 100000,
      'capacity' => fake()->numberBetween(1, 10),
      'interval' => fake()->randomElement($intervals),
      'description' => fake()->paragraphs(3, true),
      'latitude' => fake()->randomFloat(6, $jakarta->latitude->min, $jakarta->latitude->max),
      'longitude' => fake()->randomFloat(6, $jakarta->longitude->min, $jakarta->longitude->max),
      'backdrop' => null,
      'images' => null,
      'amenities' => fake()->randomElements($amenities, 6),
      'owner_id' => Owner::factory(),
    ];
  }
}
