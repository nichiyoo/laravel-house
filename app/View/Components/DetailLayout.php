<?php

namespace App\View\Components;

use App\Enums\RoleType;
use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DetailLayout extends Component
{
  /**
   * Create a new component instance.
   */
  public function __construct(
    public Property $property,
  ) {
    //
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    $user = Auth::user();

    return match ($user->role) {
      RoleType::OWNER => view('layouts.owners.detail'),
      RoleType::TENANT => view('layouts.tenants.detail'),
      RoleType::ADMIN => view('layouts.admins.detail'),
    };
  }
}
