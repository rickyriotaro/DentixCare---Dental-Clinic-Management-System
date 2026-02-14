<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class PatientNotificationController extends Controller
{
    /**
     * List all notifications for authenticated patient
     */
    public function index(Request $request)
    {
        $query = Notification::where('patient_id', $request->user()->id);
        
        // Filter unread only
        if ($request->query('unread_only') === 'true') {
            $query->where('status', 'unread');
        }
        
        $notifications = $query->latest()->get();
        $unreadCount = Notification::where('patient_id', $request->user()->id)
            ->where('status', 'unread')
            ->count();
        
        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    /**
     * Get recent notifications for dashboard (max 3)
     */
    public function recent(Request $request)
    {
        $notifications = Notification::where('patient_id', $request->user()->id)
            ->latest()
            ->limit(3)
            ->get();
        
        $unreadCount = Notification::where('patient_id', $request->user()->id)
            ->where('status', 'unread')
            ->count();
        
        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('patient_id', $request->user()->id)
            ->findOrFail($id);
        
        $notification->update(['status' => 'read']);
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca'
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request, $id)
    {
        $notification = Notification::where('patient_id', $request->user()->id)
            ->findOrFail($id);
        
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }
}
