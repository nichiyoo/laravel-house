<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $owner = Owner::first();

    Property::factory()->count(3)->create([
      'owner_id' => $owner->id,
    ]);

    Property::factory()->count(20)->create();
  }
}
