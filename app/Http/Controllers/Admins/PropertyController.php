<?php

namespace App\Http\Controllers\Admins;

use App\Enums\StatusType;
use App\Enums\VerificationType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PropertyController extends Controller
{
  public function __construct(private NotificationService $notification)
  {
    // 
  }

  /**
   * Display a listing of unverified properties.
   */
  public function unverified(): View
  {
    $keyword = request()->get('query');

    $properties = Property::unverified()
      ->with('owner')
      ->when($keyword, function ($query) use ($keyword) {
        return $query->where(function ($q) use ($keyword) {
          $q->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('city', 'like', '%' . $keyword . '%')
            ->orWhere('region', 'like', '%' . $keyword . '%')
            ->orWhere('address', 'like', '%' . $keyword . '%')
            ->orWhere('zipcode', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%');
        });
      })
      ->get();

    return view('admins.properties.unverified', [
      'properties' => $properties,
    ]);
  }

  /**
   * Display a single property.
   */
  public function show(Property $property): View
  {
    return view('admins.properties.show', [
      'property' => $property,
    ]);
  }

  /**
   * Display the location of the specified resource.
   */
  public function location(Property $property): View
  {
    return view('admins.properties.location', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Approve the specified property.
   */
  public function approve(Property $property): RedirectResponse
  {
    $property->update([
      'verification' => VerificationType::VERIFIED,
    ]);

    $this->notification->send(
      user: $property->owner->user,
      title: 'Property approved',
      message: 'Your property ' . $property->name . ' has been approved by the admin',
      action: route('owners.properties.show', $property),
    );

    return redirect()->back()
      ->with('success', 'Property approved successfully');
  }
}
