<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.roles.index', with(['roles'=>$roles]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('backend.roles.create', with(['permissions'=>$permissions]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.required' => 'Name can not be empty',
            'name.unique' => 'Name already exists'
        ]);
        $role = Role::create(['name' => $request->name]);
        // $role = DB::table('roles')->where('name', $request->name)->first();

        $permissions = $request->input('permissions');
        if(!empty($request->permissions)){
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been Created');
        return redirect('/admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::all();
        return view('backend.roles.edit', with(['permissions'=>$permissions, 'role' => $role]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,'.$id
        ], [
            'name.required' => 'Name can not be empty',
        ]);
        $role = Role::findById($id);

        $permissions = $request->input('permissions');
        if(!empty($request->permissions)){
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been Updated');
        return redirect('/admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);

        if(!is_null($role)){
            $role->delete();
        }

        session()->flash('success', 'Role has been Deleted');
        return redirect('/admin/roles');
    }
}
