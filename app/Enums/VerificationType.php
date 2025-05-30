<?php

namespace App\Enums;

enum VerificationType: string
{
  case VERIFIED = 'verified';
  case UNVERIFIED = 'unverified';

  /**
   * Get the label for the verification type.
   */
  public function label(): string
  {
    return match ($this) {
      self::VERIFIED => 'Verified',
      self::UNVERIFIED => 'Unverified',
    };
  }

  /**
   * Get the description for the verification type.
   */
  public function description(): string
  {
    return match ($this) {
      self::VERIFIED => 'Admin has verified your property',
      self::UNVERIFIED => 'Admin has not verified your property',
    };
  }
}
