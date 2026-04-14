<?php

namespace App\Http\Controllers;

use App\Models\NotificationAcademie;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(NotificationAcademie $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->update(['est_lu' => true]);

        return $this->success([
            'notification' => $notification->fresh(),
        ], 'Notification marquee comme lue.');
    }

    public function markAllAsRead(Request $request)
    {
        $updated = NotificationAcademie::where('user_id', auth()->id())
            ->where('est_lu', false)
            ->update(['est_lu' => true]);

        return $this->success([
            'updated_count' => $updated,
        ], 'Toutes les notifications ont ete marquees comme lues.');
    }
}
