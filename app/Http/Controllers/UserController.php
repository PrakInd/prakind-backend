<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // return response()->json([
        //     'data' => UserResource::collection(User::all())
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         $this->validate($request, [
//             'role_id' => 'required|numeric',
//             'name' => 'required|string|unique:users',
//             'email' => 'required|email|unique:users',
//         ]);
// 
//         try {
//             $user = User::create([
//                 'role_id' => $request->role_id,
//                 'name' => $request->name,
//                 'email' => $request->email,
//                 'password' => bcrypt($request->password),
//                 'avatar' => $this->uploadImage($request),
//             ]);
// 
//             return response()->json([$user], 201);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'code' => 409,
//                 'message' => 'Conflict',
//                 'description' => 'User creation failed!',
//                 'exception' => $e
//             ], 409);
//         }
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
                'description' => 'User with ' . $id . ' not found.'
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
            'name' => 'required|string',
            'email' => 'email|unique:users',
            'password' => 'string',
            'avatar' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update([
                'role_id' =>$request->role_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'avatar' => $this->uploadImage($request),
            ]);
            $user->save();

            // return response()->json(new UserResource($user), 201);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 409,
                'message' => 'Conflict',
                'description' => 'User update failed!',
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

            return response()->json([], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User with' . $id . ' not found.'
            ], 404);
        }
    }

    public function resetPassword($id){
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
                'description' => 'User ' . $id . ' not found.'
            ], 404);
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->photo != null) {
            $validator = Validator::make($request->all(), [
                'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return null;
            }

            $file = $request->file('photo');
            $path = 'storage/' . basename( $_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);

            return $path;
        }
    }
}
