<?php

namespace App\Enums;

enum RoleType: string
{
  case ADMIN = 'admin';
  case OWNER = 'owner';
  case TENANT = 'tenant';

  /**
   * Get the label for the role type.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::ADMIN => 'Administrator',
      self::OWNER => 'Property Owner',
      self::TENANT => 'Tenant',
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
      self::ADMIN => 'Administrator of the system',
      self::OWNER => 'Owner of the property',
      self::TENANT => 'Tenant or user of the property',
    };
  }
}
