<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProfileResource::collection(Profile::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('pelamar')) {
            $this->validate($request, [
                'address' => 'required|string',
                'phone' => 'required|string',
                'gpa' => 'required|string',
                'semester' => 'required|numerical',
            ]);

            try {
                $profile = Profile::create([
                    'user_id' => $request->user_id,
                    'institution_id' => $request->institution_id,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'gpa' => $request->gpa,
                    'semester' => $request->semester,
                    'cv' => $request->cv,
                    'transcript' => $request->transcript,
                    'portfolio' => $request->portfolio,
                ]);

                return response()->json([$profile], 201);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Profile creation failed.'
                ], 404);
            }
        }
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
            if (Gate::allows('admin')) {
                return new ProfileResource(Profile::findOrFail($id));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => $e->getMessage(),
            ]);
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
        if (Gate::allows('pelamar')) {
            $this->validate($request, [
                'address' => 'required|string',
                'phone' => 'required|string',
                'gpa' => 'required|string',
                'semester' => 'required|numerical',
            ]);

            try {
                $profile = Profile::findOrFail($id);
                $profile->update($request->all());

                return new ProfileResource($profile);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Profile with ' . $id . ' not found.'
                ], 404);
            }
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
        if (Gate::allows('pelamar')) {
            try {
                Profile::findOrFail($id)->delete();
    
                return response()->json([], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Profile with' . $id . ' not found.'
                ], 404);
            }
        }
    }
}
