<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            // new Middleware('permission:create users', only:['create']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:update users', only: ['update']),
            new Middleware('permission:destroy users', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view(
            'users.list',
            [
                'users' => $users
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validate input correctly
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'roles' => 'nullable|array'
        ]);

        // ✅ Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // ✅ Assign roles if any selected
        if (!empty($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        // ✅ Redirect back with success message
        return redirect()->route('user.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::with('roles')->findOrFail($id);
        $roles = Role::orderBy('name', 'ASC')->get();

        // Correct method
        $hasRoles = $users->roles->pluck('id');

        return view('users.edit', [
            'users' => $users,
            'roles' => $roles,
            'hadRoles' => $hasRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);
        if ($validator->fails()) {
            return redirect()->route('user.edit', $id)->withInput()->withErrors($validator);
        }
        $users->name = $request->name;
        $users->email = $request->email;
        $users->save();

        $users->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success', 'User updated successfull.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Optionally, prevent deleting special users (like admin)
        if ($user->hasRole('Admin')) {
            return redirect()->route('user.index')
                ->with('error', 'You cannot delete an Admin user.');
        }

        // Delete user
        $user->delete();

        // Redirect back with success message
        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully.');
    }
}
