<?php

namespace App\Http\Controllers;

use App\Models\ProjectMessage;
use Illuminate\Http\Request;

class ProjectMessageController extends Controller
{
    public function index()
    {
        return ProjectMessage::all();
    }

    public function show($id)
    {
        return ProjectMessage::findOrFail($id);
    }

    public function store(Request $request)
    {
        return ProjectMessage::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $message = ProjectMessage::findOrFail($id);
        $message->update($request->all());
        return $message;
    }

    public function destroy($id)
    {
        ProjectMessage::destroy($id);
        return response()->json(['message' => 'Project message deleted successfully']);
    }
}
