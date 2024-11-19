<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function show($id)
    {
        return Project::findOrFail($id);
    }

    public function store(Request $request)
    {
        return Project::create($request->all());
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
        $batchSize = $request->input('batchSize', 2);  // Tamaño del lote (10 por defecto)
        $offset = $request->input('offset', 0);         // Desde dónde empezar

        // Obtener un lote de proyectos
        $projects = Project::orderBy('created_at', 'desc')  // Ordenados por fecha de creación
            ->skip($offset)
            ->take($batchSize)
            ->get();

        return response()->json($projects);
    }
}
