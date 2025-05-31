<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RoleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompletedProfile
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user = Auth::user();

    $role = $user->role;
    if (!$user || $role !== RoleType::TENANT) abort(403);

    $tenant = $user->tenant;
    if (!$tenant->completed) {
      return redirect()
        ->route('tenants.profile')
        ->with('error', 'Please complete your profile');
    }

    return $next($request);
  }
}
