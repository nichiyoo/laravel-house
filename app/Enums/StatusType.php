<?php

namespace App\Enums;

enum StatusType: string
{
  case PENDING = 'pending';
  case CANCELLED = 'cancelled';
  case APPROVED = 'approved';
  case REJECTED = 'rejected';
  case COMPLETED = 'completed';

  /**
   * Get the label for the status type.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::PENDING => 'Pending',
      self::CANCELLED => 'Cancelled',
      self::APPROVED => 'Approved',
      self::REJECTED => 'Rejected',
      self::COMPLETED => 'Completed',
    };
  }

  /**
   * Get the description for the status type.
   *
   * @return string
   */
  public function description(): string
  {
    return match ($this) {
      self::PENDING => 'Waiting for approval',
      self::APPROVED => 'Approved by the owner',
      self::REJECTED => 'Rejected by the owner',
      self::COMPLETED => 'Rental period completed',
      self::CANCELLED => 'Rental application cancelled',
    };
  }

  /**
   * Get the color for the status type.
   *
   * @return string
   */
  public function color(): string
  {
    return match ($this) {
      self::PENDING => 'bg-base-500',
      self::APPROVED => 'bg-green-500',
      self::REJECTED => 'bg-red-500',
      self::COMPLETED => 'bg-blue-500',
      self::CANCELLED => 'bg-red-500',
    };
  }
}
