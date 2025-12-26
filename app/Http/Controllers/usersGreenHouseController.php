<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersGreenHouse;
use Illuminate\Support\Facades\Hash;

class UsersGreenHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UsersGreenHouse::all();

        return response()->json([
            'data' => $users,
            'message' => $users->count() > 0 ? 'All Users' : 'No Users Found Yet'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:usersgreenhouse,email',
            'password' => 'required|min:6',
            'role'     => 'required|string'
        ]);

        $user = UsersGreenHouse::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'User created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = UsersGreenHouse::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = UsersGreenHouse::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:usersgreenhouse,email,' . $id,
            'password' => 'sometimes|min:6',
            'role' => 'sometimes|string'
        ]);

        $user->name  = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->role  = $request->role ?? $user->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'data' => $user,
            'message' => 'User updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = UsersGreenHouse::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
