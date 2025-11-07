<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller // implements HasMiddleware
{
    // public static function middleware()
    // {
    //     return [
    //         new Middleware('permission:view permission', only: ['index']),
    //         new Middleware('permission:create permission', only: ['create']),
    //         new Middleware('permission:edit permission', only: ['edit']),
    //         new Middleware('permission:destroy permission', only: ['destroy']),
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showData = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('list', compact('showData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);
        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permission.index')->with('success', 'Permission added Successfull.');
        } else {
            return redirect()->route('permission.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);
        // Find the permission by ID
        $permission = Permission::findOrFail($id);
        // Update the record
        $permission->update([
            'name' => $request->name,
        ]);
        // Redirect with success message
        return redirect()->route('permission.index')->with('success', 'Permission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the permission by ID
        $permission = Permission::findOrFail($id);
        // Delete the record
        $permission->delete();
        // Redirect with a success message
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
