<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class RoleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view roles', only:['index']),
            new Middleware('permission:create roles', only:['create']),
            new Middleware('permission:edit roles', only:['edit']),
            new Middleware('permission:update roles', only:['update']),
            new Middleware('permission:destroy roles', only:['destroy']),
        ];
    }
    public function index()
    {
        // Get all roles with pagination (optional)
        $showData = Role::orderBy('created_at', 'DESC')->paginate(10);
        // Return to the roles.index view
        return view('roles.index', compact('showData'));
    }

    public function create()
    {
        // Get all permissions sorted by name
        $permission = Permission::orderBy('name', 'ASC')->get();
        // Return to the create view
        return view('roles.create', compact('permission'));
    }
    public function store(Request $request)
    {
        // Validate role name
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()) {
            // Create new role
            $role = Role::create(['name' => $request->name]);
            // Assign selected permissions
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('role.index')
                ->with('success', 'Role added successfully.');
        }
        return redirect()->route('role.create')
            ->withInput()
            ->withErrors($validator);
    }
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        // Update permissions
        $role->syncPermissions($request->permission ?? []);

        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        // Optional: prevent deleting important roles like "Admin"
        if ($role->name === 'Admin') {
            return redirect()->route('role.index')->with('error', 'Cannot delete Admin role.');
        }
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');
    }
    public function show() {}
}
