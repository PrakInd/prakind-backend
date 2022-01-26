<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupResource::collection(Group::all());
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
                'referral_code' => 'nullable|string',
            ]);

            try {
                $group = Group::create([
                    'referral_code' => $request->referral_code,
                ]);

                return response()->json([$group], 201);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Group creation failed.'
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
                return new GroupResource(Group::findOrFail($id));
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
                'referral_code' => 'required',
            ]);

            try {
                $group = Group::findOrFail($id);
                $group->update($request->all());

                return new GroupResource($group);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Group with ' . $id . ' not found.'
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
                Group::findOrFail($id)->delete();
    
                return response()->json([], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Group with' . $id . ' not found.'
                ], 404);
            }
        }
    }
}
