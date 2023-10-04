<?php

namespace BDS\Http\Controllers\API;

use BDS\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = Auth::user()->notifications;
        $unreadNotificationsCount = auth()->user()->unreadNotifications->count();
        $hasUnreadNotifications = auth()->user()->unreadNotifications->isNotEmpty();

        return response()->json(compact('notifications', 'unreadNotificationsCount', 'hasUnreadNotifications'));
    }

    /**
     * Delete a notification by its ID.
     *
     * @param \Illuminate\Http\Request $request The current request.
     * @param string $slug The notification ID.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, string $slug): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()
            ->where('id', $slug)
            ->first();

        if ($notification) {
            $notification->delete();
        }

        return response()->json([
            'error' => false
        ]);
    }

    /**
     * Mark a notification as read.
     *
     * @param \Illuminate\Http\Request $request The current request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()
            ->where('id', $request->input('id'))
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json([
            'error' => false
        ]);
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'error' => false
        ]);
    }
}
