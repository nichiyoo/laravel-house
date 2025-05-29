<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
  /**
   * Register the middleware
   */
  public function __construct()
  {
    $this->authorizeResource(Notification::class, 'notification');
  }

  /**
   * get user notifications
   */
  public function index(): View
  {
    $notifications = Auth::user()->notifications()->latest()->get();
    return view('notifications', [
      'notifications' => $notifications,
    ]);
  }

  /**
   * mark notification as read
   */
  public function read(Notification $notification): RedirectResponse
  {
    $notification->read = true;
    $notification->save();
    return redirect()->back();
  }

  /**
   * mark all notifications as read
   */
  public function all(): RedirectResponse
  {
    Auth::user()->notifications()->update([
      'read' => true
    ]);
    return redirect()->back();
  }

  /**
   * remove notification
   */
  public function destroy(Notification $notification): RedirectResponse
  {
    $notification->delete();
    return redirect()->back();
  }


  /**
   * remove all notifications
   */
  public function purge(): RedirectResponse
  {
    Auth::user()->notifications()->delete();
    return redirect()->back();
  }
}
