<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Owner::create([
      'user_id' => User::factory()->create([
        'name' => 'Owner',
        'email' => 'owner@example.com',
        'role' => RoleType::OWNER,
      ])->id,
    ]);

    Tenant::create([
      'completed' => true,
      'address' => 'Jl. Raya Kedungjaya No. 123, Kedungjaya, Jepara, Indonesia',
      'latitude' => -6.200000,
      'longitude' => 106.816666,
      'user_id' => User::factory()->create([
        'name' => 'Tenant',
        'email' => 'tenant@example.com',
        'role' => RoleType::TENANT,
      ])->id,
    ]);

    Admin::create([
      'user_id' => User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'role' => RoleType::ADMIN,
      ])->id,
    ]);
  }
}
