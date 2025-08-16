<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return response()->json([
            'data' => $notifications,
            'message' => 'Notifications retrieved successfully',
        ]);
    }
}
