<?php

namespace App\Enums;

enum MethodType: string
{
  case CASH = 'cash';
  case DANA = 'dana';
  case GOPAY = 'gopay';

  /**
   * Get the label for the payment method.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::CASH => 'Cash',
      self::DANA => 'Dana',
      self::GOPAY => 'Gopay',
    };
  }

  /**
   * Get the description for the payment method.
   *
   * @return string
   */
  public function description(): string
  {
    return match ($this) {
      self::CASH => 'Pay in cash',
      self::DANA => 'Pay in Dana',
      self::GOPAY => 'Pay in Gopay',
    };
  }
}
