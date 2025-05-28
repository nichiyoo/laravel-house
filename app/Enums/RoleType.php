<?php

namespace App\Enums;

enum RoleType: string
{
  case TENANT = 'tenant';
  case OWNER = 'owner';
  case ADMIN = 'admin';

  /**
   * Get the label for the role type.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::TENANT => 'Tenant',
      self::OWNER => 'Owner',
      self::ADMIN => 'Administrator',
    };
  }

  /**
   * Get the description for the role type.
   *
   * @return string
   */
  public function description(): string
  {
    return match ($this) {
      self::TENANT => 'Tenant or user of the property',
      self::OWNER => 'Owner of the property',
      self::ADMIN => 'Administrator of the system',
    };
  }

  /**
   * Get the save choices for the role type.
   *
   * @return array
   */
  public static function save(): array
  {
    return array_filter(self::cases(), fn(RoleType $role) => $role !== self::ADMIN);
  }
}
