<?php

namespace App\Http\Controllers;

use App\Models\PrivateMessages;
use Illuminate\Http\Request;

class PrivateMessagesController extends Controller
{
    public function index()
    {
        return PrivateMessages::all();
    }

    public function show($id)
    {
        return PrivateMessages::findOrFail($id);
    }

    public function store(Request $request)
    {
        return PrivateMessages::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $message = PrivateMessages::findOrFail($id);
        $message->update($request->all());
        return $message;
    }

    public function destroy($id)
    {
        PrivateMessages::destroy($id);
        return response()->json(['message' => 'Private message deleted successfully']);
    }
}
