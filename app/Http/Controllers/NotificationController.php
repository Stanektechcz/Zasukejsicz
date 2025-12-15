<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete(Notification $notification)
    {
        // Check if user owns this notification or if it's a global notification
        if ($notification->user_id === Auth::id() || $notification->is_global) {
            $notification->delete();
            return back()->with('success', 'Notification deleted');
        }

        abort(403);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id() || $notification->is_global) {
            $notification->markAsRead();
            return back();
        }

        abort(403);
    }
}
