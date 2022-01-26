<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstitutionResource;
use App\Models\Institution;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InstitutionResource::collection(Institution::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('admin')) {
            $this->validate($request, [
                'name' => 'required|string',
                'level' => 'required|string',
            ]);

            try {
                $institution = Institution::create([
                    'name' => $request->name,
                    'level' => $request->level,
                ]);

                return response()->json([$institution], 201);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Institution creation failed.'
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
        //
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
        if (Gate::allows('admin')) {
            $this->validate($request, [
                'name' => 'required|string',
                'level' => 'required|string',
            ]);

            try {
                $institution = Institution::findOrFail($id);
                $institution->update($request->all());

                return new InstitutionResource($institution);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Institution with ' . $id . ' not found.'
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
        if (Gate::allows('admin')) {
            try {
                Institution::findOrFail($id)->delete();
    
                return response()->json([], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Institution with' . $id . ' not found.'
                ], 404);
            }
        }
    }
}
