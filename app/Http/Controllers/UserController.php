<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $perPage = 8;
        $users = User::paginate($perPage);

        return response()->json($users);
    }

    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }


public function search(Request $request)
{
    $query = $request->input('query', '');
    $page = $request->input('page', 1);
    $perPage = $request->input('perPage', 10);

    $users = User::where('username', 'LIKE', "%$query%")
                 ->paginate($perPage, ['*'], 'page', $page);

    return response()->json($users);
}





    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'level' => 'required|string',
            'bio' => 'nullable|string',
            'interests' => 'nullable|string',
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }


}
