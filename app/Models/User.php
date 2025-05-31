<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleType;
use App\Traits\HasImageUpload;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, HasImageUpload;

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
   * get user avatar
   */
  protected function avatar(): Attribute
  {
    $default = 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=e1e1e1&size=256&font-size=0.33';
    return Attribute::make(
      get: fn() => $this->attributes['avatar'] ?? $default
    );
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
    return $this->hasOne(Tenant::class);
  }

  /**
   * get user notifications
   */
  public function notifications(): HasMany
  {
    return $this->hasMany(Notification::class);
  }
}
