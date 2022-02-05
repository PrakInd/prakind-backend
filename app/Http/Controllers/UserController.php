<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new UserResource(User::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User with id ' . $id . ' not found.'
            ], 404);
        }
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
        $this->validate($request, [
            'name' => 'string',
            'email' => 'email|unique:users',
            'password' => 'string',
        ]);

        try {
            $user = User::findOrFail($id);
            // $user->update($request->all());

            // Cara 1
            $user->update([
                'role_id' => $request->role_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Cara 2
            // $user->role_id = $request->input('role_id');
            // $user->name = $request->input('name');
            // $user->email = $request->input('email');
            // $user->password = bcrypt($request->input('password'));
            // $user->avatar = $request->input('avatar');
            // $user->update($request);

            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 409,
                'message' => 'Conflict',
                'description' => 'User update failed.',
                'exception' => $e
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                 'description' => 'User with ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User with id ' . $id . ' not found.'
            ], 404);
        }
    }

    public function resetPassword($id) 
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'password'=> bcrypt('password')]
            );
            
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User with id ' . $id . ' not found.'
            ], 404);
        }
    }

    public function uploadImage(Request $request, $id)
    {
        try {
            $request->validate([
                'avatar' => ['mimes:png,jpg,jpeg', 'max:2048'],
            ]);
    
            $data = User::findOrFail($id);
            $imageName = $request->id . "-" . "avatar" . "." . $request->avatar->extension();
            $path = public_path('images/');
            $request->avatar->move($path, $imageName);
            $image = "images/" . $imageName;
            $data->avatar = $image;
            $data->save();
    
            return response()->json([
                'code' => 200,
                'data' => new UserResource($data)
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        } 
    }
}
