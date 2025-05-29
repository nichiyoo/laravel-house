<?php

namespace App\Enums;

enum IntervalType: string
{
  case MONTHLY = 'monthly';
  case QUARTERLY = 'quarterly';
  case HALFYEAR = 'halfyear';
  case YEARLY = 'yearly';

  /**
   * Get the label for the interval type.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::MONTHLY => 'Monthly',
      self::QUARTERLY => 'Quarterly',
      self::HALFYEAR => 'Half Yearly',
      self::YEARLY => 'Yearly',
    };
  }

  /**
   * Get the description for the interval type.
   *
   * @return string
   */
  public function description(): string
  {
    return match ($this) {
      self::MONTHLY => 'Monthly',
      self::QUARTERLY => 'Quarterly',
      self::HALFYEAR => 'Half Yearly',
      self::YEARLY => 'Yearly',
    };
  }

  /**
   * Get the color for the interval type.
   *
   * @return string
   */
  public function color(): string
  {
    return match ($this) {
      self::MONTHLY => 'bg-amber-500',
      self::QUARTERLY => 'bg-green-500',
      self::HALFYEAR => 'bg-blue-500',
      self::YEARLY => 'bg-purple-500',
    };
  }

  /**
   * Function to calculate the price for the interval type.
   *
   * @param int $price
   * @return int
   */
  public function calculate(int $price): int
  {
    $ratio = match ($this) {
      self::MONTHLY => 1,
      self::QUARTERLY => 3,
      self::HALFYEAR => 6,
      self::YEARLY => 12,
    };

    return $price * $ratio;
  }

  /**
   * Get the unit name for the interval type.
   *
   * @return string
   */
  public function unit(): string
  {
    return match ($this) {
      self::MONTHLY => 'month',
      self::QUARTERLY => 'quarter',
      self::HALFYEAR => 'half year',
      self::YEARLY => 'year',
    };
  }

  /**
   * Get the ratio for the interval type.
   *
   * @return int
   */
  public function ratio(): int
  {
    return match ($this) {
      self::MONTHLY => 1,
      self::QUARTERLY => 3,
      self::HALFYEAR => 6,
      self::YEARLY => 12,
    };
  }
}
