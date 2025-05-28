<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'phone',
    'avatar',
    'google_id',
    'google_token',
    'google_refresh_token',
    'github_id',
    'github_token',
    'github_refresh_token',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'role' => RoleType::class,
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /**
   * Get the owner associated with the user.
   */
  public function owner(): HasOne
  {
    return $this->hasOne(Owner::class);
  }

  /** 
   * Get the admin associated with the user.
   */
  public function admin(): HasOne
  {
    return $this->hasOne(Admin::class);
  }

  /**
   * Get the tenant associated with the user.
   */
  public function tenant(): HasOne
  {
    return $this->hasOne(Tenant::class)
      ->withDefault([
        'completed' => false,
        'address' => 'No address',
        'latitude' => 0,
        'longitude' => 0,
      ]);
  }
}
