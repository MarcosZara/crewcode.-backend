<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $notifications = Notification::where('user_id', $user_id)
                                      ->orderBy('created_at', 'desc')
                                      ->get();
        return response()->json($notifications);
    }

    public function show($id)
    {
        return Notification::findOrFail($id);
    }

    public function store(Request $request)
    {
        return Notification::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($request->all());
        return $notification;
    }

    public function destroy($id)
    {
        Notification::destroy($id);
        return response()->json(['message' => 'Notification deleted successfully']);
    }
}
