<?php

namespace App\Http\Controllers;
use App\Models\ProjectRequest;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ProjectMember;


class ProjectRequestController extends Controller
{

    public function index(Request $request)
{
    $requests = ProjectRequest::whereHas('project', function ($query) {
        $user_id = auth()->id();
        $query->where('creator_id', $user_id);
    })->where('status', 'pending')
      ->with('user')->with('project')
      ->orderBy('created_at', 'desc')
      ->get();

    return response()->json($requests);
}

    public function store(Request $request, $projectId)
{
    $user_id = auth()->id();


    $existingRequest = ProjectRequest::where('user_id', $user_id)
        ->where('project_id', $projectId)
        ->where('status', 'pending')
        ->first();

    if ($existingRequest) {
        return response()->json(['message' => 'Ya has solicitado unirte a este proyecto.'], 400);
    }


    $projectRequest = ProjectRequest::create([
        'user_id' => $request->user()->id,
        'project_id' => $projectId,
    ]);


    $creator = $projectRequest->project->creator;
    if (!$creator) {
        return response()->json(['message' => 'El proyecto no tiene un creador válido.'], 400);
    }


    Notification::create([
        'user_id' => $creator->id,
        'project_id' => $projectId,
        'message' => "<strong>{$request->user()->username}</strong> quiere unirse a tu proyecto <strong>{$projectRequest->project->title}</strong>.",
        'type' => 'request',
    ]);

    return response()->json(['message' => 'Solicitud enviada con éxito.']);
}


    public function respond(Request $request, $id)
    {
        $projectRequest = ProjectRequest::findOrFail($id);

        $status = $request->input('status');
        $projectRequest->status = $status;
        $projectRequest->save();
        $projectTitle = $projectRequest->project->title;

        Notification::create([
            'user_id' => $projectRequest->user_id,
            'project_id' => $projectRequest->project_id,
            'message' => $status === 'accepted'
               ? "Has sido aceptado en el proyecto <strong>$projectTitle</strong>."
            : "Tu solicitud al proyecto <strong>$projectTitle</strong> ha sido rechazada.",
            'type' => 'response',
        ]);


        if ($status === 'accepted') {
            $projectRequest->project->members()->attach($projectRequest->user_id);
        }

        return response()->json(['message' => 'Respuesta registrada']);
    }
}
