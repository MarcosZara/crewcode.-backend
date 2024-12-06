<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function show($id)
    {
        $project = Project::with([
            'messages.user',
            'members',
        ])->findOrFail($id);

        return response()->json($project);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|min:5',
                'level' => 'required',
                'description' => 'required|string|min:10',
                'theme' => 'required|string',
                'estimatedEndDate' => 'required|date',
                'teamSize' => 'nullable|integer',
                'goal' => 'nullable|string',
                'repositoryUrl' => 'nullable|url',
                'image_url' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }


        $imagePath = $request->file('image_url')->store('projects', 'public');
$imageUrl = 'http://crewcode.lo' . Storage::url($imagePath);


        $project = Project::create([
            'title' => $validated['title'],
            'level' => $validated['level'],
            'description' => $validated['description'],
            'theme' => $validated['theme'],
            'creator_id' => auth()->id(),
            'status' => 'Activo',
            'image_url' => $imageUrl,
            'technologies' => $request->input('technologies'),
            'duration' => $request->input('duration'),
            'goal' => $validated['goal'] ?? null,
            'team_size' => $validated['teamSize'] ?? null,
            'repository_url' => $validated['repositoryUrl'] ?? null,
        ]);

        return response()->json(['message' => 'Proyecto creado exitosamente', 'project' => $project], 201);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $project;
    }

    public function destroy($id)
    {
        Project::destroy($id);
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function getProjectBatch(Request $request)
    {
        $batchSize = $request->input('batchSize', 2);
        $offset = $request->input('offset', 0);


        $projects = Project::orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($batchSize)
            ->where('status', 'Activo')
            ->get();

        return response()->json($projects);
    }


    public function getUserProjects(Request $request, $userId)
{

  $memberProjects = DB::table('project_members')
  ->join('projects', 'projects.id', '=', 'project_members.project_id')
  ->where('project_members.user_id', $userId)
  ->select('*')
  ->get();


$creatorProjects = DB::table('projects')
  ->where('projects.creator_id', $userId)
  ->select('*')
  ->get();


$projects = $memberProjects->merge($creatorProjects);

return response()->json($projects);
}

//     public function getUserProjects(Request $request, $userId)
// {
//     // Obtener los proyectos en los que el usuario está participando y que están activos
//     $projects = Project::whereHas('members', function($query) use ($userId) {
//             $query->where('user_id', $userId);  // Filtrar proyectos donde el usuario está participando
//         })
//         ->where('status', 'Activo')  // Solo proyectos activos
//         ->orderBy('created_at', 'desc')  // Ordenar por fecha de creación
//         ->get();

//     return response()->json($projects);
// }
//     public function getUserProjects(Request $request, $userId)
// {


//     // Obtener los proyectos en los que el usuario participa y que están activos
//     $projects = Project::whereHas('creator', function($query) use ($userId) {
//             $query->where('creator_id', $userId);  // Filtrar proyectos donde el usuario es participante
//         })

//         ->orderBy('created_at', 'desc')  // Ordenar por fecha de creación
//         ->get();

//     return response()->json($projects);
// }


    public function getProjectMembers($id)
    {

        $project = Project::with('members')->findOrFail($id);


        return response()->json($project->members);
    }
}
