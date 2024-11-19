<?php

namespace App\Http\Controllers;

use App\Models\ProjectMember;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectMemberController extends Controller
{

     public function addMemberToProject($projectId, $userId)
     {
         $project = Project::findOrFail($projectId);
         $user = User::findOrFail($userId);


         if (!$project->members()->where('user_id', $userId)->exists()) {
             $project->members()->attach($user);
             return response()->json(['message' => 'User added to project successfully.']);
         }

         return response()->json(['message' => 'User is already a member of this project.'], 400);
     }


     public function removeMemberFromProject($projectId, $userId)
     {
         $project = Project::findOrFail($projectId);
         $user = User::findOrFail($userId);

         $project->members()->detach($user);

         return response()->json(['message' => 'User removed from project successfully.']);
     }


     public function getProjectMembers($projectId)
     {
         $project = Project::findOrFail($projectId);
         $members = $project->members;

         return response()->json($members);
     }


     public function getUserProjects($userId)
     {
         $user = User::findOrFail($userId);
         $projects = $user->projects;
         return response()->json($projects);
     }
}
