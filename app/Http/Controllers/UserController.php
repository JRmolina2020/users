<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\User;



class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        // $users = DB::table('users')->select('id', 'name', 'surname', 'status', 'email', 'image')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {

        $user = $request->all();
        if ($request->hasFile('image')) {
            $user['image'] = $request->file('image')->store('uploads', 'public');
        }
        $user = User::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'image' => $request->file('image')->store('uploads', 'public')
        ]);
        $user->roles()->sync($request['rol']);
        return response()->json(['message' => 'El usuario ha sido creado'], 200);
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
        $user = User::find($id);
        $user->fill([
            'name' => request('name'),
            'surname' => request('surname'),
            'email' => request('email'),
        ])->save();
        $user->roles()->sync($request['rol']);
        return response()->json(['message' => 'El usuario ha sido modificado'], 201);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (Storage::delete('public/' . $user->image)) {
            User::destroy($id);
        }

        return response()->json(["message" => "Ha sido eliminado"]);
    }
    public function available($id)
    {
        $users = User::findOrFail($id);
        $users->status = '1';
        $users->save();
        return response()->json(["message" => "Ha sido activado"]);
    }
    public function locked($id)
    {
        $users = User::findOrFail($id);
        $users->status = '0';
        $users->save();
        return response()->json(["message" => "Ha sido Bloqueado"]);
    }

    public function updatepassword(Request $request, $id)
    {
        $user = User::find($id);
        $user->fill([
            $user['password'] = bcrypt($request['password'])

        ])->save();
        return response()->json(['message' => 'El password ha sido cambiado'], 201);
    }
}