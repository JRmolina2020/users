<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('id', 'DESC')->get();
        return response()->json($user);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $validator = Validator::make(request()->input(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        $user = $request->all();
        if ($request->hasFile('image')) {
            $user['image'] = $request->file('image')->store('uploads', 'public');
        }
        $user['password'] = bcrypt($request['password']);
        User::insert($user);
        return response()->json(['message' => 'Ha sido Registrado'], 200);
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
        return response()->json(compact('user'), 201);
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
        return response()->json(compact('user'), 201);
    }
}