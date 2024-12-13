<?php

namespace App\Http\Controllers;

use App\Models\ProjectMessage;
use Illuminate\Http\Request;
use App\Events\ProjectMessageSent;

class ProjectMessageController extends Controller
{


    public function index($projectId)
    {
        $messages = ProjectMessage::where('project_id', $projectId)
        ->with('user')
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    public function show($id)
    {
        return ProjectMessage::findOrFail($id);
    }

    public function store(Request $request, $projectId)
    {
        $user_id = auth()->id();

        $message = ProjectMessage::create([
            'project_id' => $projectId,
            'user_id' => $user_id,
            'message_content' => $request->message,
        ]);

        $message->load('user');

        broadcast(new ProjectMessageSent($message))->toOthers();


        return response()->json($message);
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
