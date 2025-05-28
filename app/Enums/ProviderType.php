<?php

namespace App\Enums;

enum ProviderType: string
{
  case GOOGLE = 'google';
  case GITHUB = 'github';

  /**
   * Get the svg icon path for the provider type.
   *
   * @return string
   */
  public function icon(): string
  {
    return match ($this) {
      self::GOOGLE => asset('icons/google.svg'),
      self::GITHUB => asset('icons/github.svg'),
    };
  }
}
