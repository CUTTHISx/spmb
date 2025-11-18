<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($notification) {
            $notification->markAsRead();
        }
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return response()->json(['success' => true]);
    }
    
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();
            
        return response()->json(['count' => $count]);
    }
}