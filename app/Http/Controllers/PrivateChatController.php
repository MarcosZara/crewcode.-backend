<?php

namespace App\Http\Controllers;

use App\Models\PrivateChat;
use Illuminate\Http\Request;

class PrivateChatController extends Controller
{
    public function index()
    {
        return PrivateChat::all();
    }

    public function show($id)
    {
        return PrivateChat::findOrFail($id);
    }

    public function store(Request $request)
    {
        return PrivateChat::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $chat = PrivateChat::findOrFail($id);
        $chat->update($request->all());
        return $chat;
    }

    public function destroy($id)
    {
        PrivateChat::destroy($id);
        return response()->json(['message' => 'Private chat deleted successfully']);
    }
}
