<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return true;
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->role === RoleType::OWNER;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Property $property): bool
  {
    return false;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Property $property): bool
  {
    return false;
  }

  /**
   * Determine whether the user can view the reviews of the model.
   */
  public function reviews(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /**
   * Determine whether the user can view the location of the model.
   */
  public function location(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /** 
   * Determine whether the user can view the applications of the model.
   */
  public function applications(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /**
   * Determine whether the user can approve the model.
   */
  public function approve(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }

  /**
   * Determine whether the user can reject the model.
   */
  public function reject(User $user, Property $property): bool
  {
    return $property->owner->user->is($user);
  }
}
