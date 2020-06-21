<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Role;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {;

        $roles = Role::with('permissions')->get();
        //$roles = DB::table('roles')->select('id', 'name')->get();
        return response()->json($roles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = Role::create([
            'name' => $request['name'],

        ]);
        $roles->save();
        return response()->json(['message' => 'El rol ha sido creado'], 200);
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
        $role = Role::find($id);
        $role->fill([
            'name' => request('name'),
        ])->save();
        $role->permissions()->sync($request['permissions']);
        return response()->json(['message' => 'El rol ha sido modificado'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}