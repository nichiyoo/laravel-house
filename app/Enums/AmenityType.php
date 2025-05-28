<?php

namespace App\Enums;

enum AmenityType: string
{
  case TV = 'tv';
  case WIFI = 'wifi';
  case PARKING = 'parking';
  case WASHING_MACHINE = 'washing_machine';
  case AIR_CONDITIONER = 'air_conditioner';
  case REFRIGERATOR = 'refrigerator';
  case KITCHENETTE = 'kitchenette';
  case BATHTUB = 'bathtub';
  case BALCONY = 'balcony';
  case SHOWER = 'shower';

  /**
   * Get the label for the amenities type.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::TV => 'Television',
      self::WIFI => 'Wi-Fi',
      self::PARKING => 'Parking',
      self::WASHING_MACHINE => 'Washing Machine',
      self::AIR_CONDITIONER => 'Air Conditioner',
      self::REFRIGERATOR => 'Refrigerator',
      self::KITCHENETTE => 'Kitchenette',
      self::BATHTUB => 'Bathtub',
      self::BALCONY => 'Balcony',
      self::SHOWER => 'Shower',
    };
  }

  /**
   * Get the description for the amenities type.
   *
   * @return string
   */
  public function description(): string
  {
    return match ($this) {
      self::TV => 'Television for entertainment',
      self::WIFI => 'High-speed internet access',
      self::PARKING => 'Parking space available',
      self::WASHING_MACHINE => 'In-unit washing machine',
      self::AIR_CONDITIONER => 'Air conditioning for comfort',
      self::REFRIGERATOR => 'Refrigerator for food storage',
      self::KITCHENETTE => 'Small kitchen area',
      self::BATHTUB => 'Bathtub for relaxation',
      self::BALCONY => 'Private balcony space',
      self::SHOWER => 'Shower for bathing',
    };
  }

  /**
   * Get the icon for the amenities type.
   *
   * @return string
   */
  public function icon(): string
  {
    return match ($this) {
      self::TV => 'tv',
      self::WIFI => 'wifi',
      self::PARKING => 'parking-circle',
      self::WASHING_MACHINE => 'washing-machine',
      self::AIR_CONDITIONER => 'air-vent',
      self::REFRIGERATOR => 'refrigerator',
      self::KITCHENETTE => 'cooking-pot',
      self::BATHTUB => 'bath',
      self::BALCONY => 'house',
      self::SHOWER => 'shower-head',
    };
  }
}
