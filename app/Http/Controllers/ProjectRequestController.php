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
        $requests = ProjectRequest::whereHas('project', function ($query) use ($request) {

        $user_id = auth()->id();
            $query->where('user_id', $user_id); // Proyectos creados por el usuario logueado
        })->with('user')->orderBy('created_at', 'desc')->get();

        return response()->json($requests);
    }

    public function store(Request $request, $projectId)
{
    $user_id = auth()->id();

    // Verificar si ya hay una solicitud pendiente
    $existingRequest = ProjectRequest::where('user_id', $user_id)
        ->where('project_id', $projectId)
        ->where('status', 'pending')
        ->first();

    if ($existingRequest) {
        return response()->json(['message' => 'Ya has solicitado unirte a este proyecto.'], 400);
    }

    // Crear la solicitud
    $projectRequest = ProjectRequest::create([
        'user_id' => $request->user()->id,
        'project_id' => $projectId,
    ]);

    // Obtener al creador del proyecto
    $creator = $projectRequest->project->creator; // Relación Project -> User
    if (!$creator) {
        return response()->json(['message' => 'El proyecto no tiene un creador válido.'], 400);
    }

    // Notificar al creador del proyecto
    Notification::create([
        'user_id' => $creator->id, // ID del creador del proyecto
        'project_id' => $projectId,
        'message' => "{$request->user()->username} quiere unirse a tu proyecto.",
        'type' => 'request',
    ]);

    return response()->json(['message' => 'Solicitud enviada con éxito.']);
}


    public function respond(Request $request, $id)
    {
        $projectRequest = ProjectRequest::findOrFail($id);

        $status = $request->input('status'); // 'accepted' o 'rejected'
        $projectRequest->status = $status;
        $projectRequest->save();

        // Crear una notificación para el solicitante
        Notification::create([
            'user_id' => $projectRequest->user_id,
            'project_id' => $projectRequest->project_id,
            'message' => $status === 'accepted'
                ? 'Has sido aceptado en el proyecto.'
                : 'Tu solicitud ha sido rechazada.',
            'type' => 'response',
        ]);

        // Si aceptado, añadir al usuario como miembro del proyecto
        if ($status === 'accepted') {
            $projectRequest->project->members()->attach($projectRequest->user_id);
        }

        return response()->json(['message' => 'Respuesta registrada']);
    }
}
