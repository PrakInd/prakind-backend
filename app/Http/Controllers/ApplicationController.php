<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApplicationResource::collection(Application::all());
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
            return new ApplicationResource(Application::findOrFail($id));
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
        if (Gate::allows('admin')) {
            $this->validate($request, [
                'status' => 'required|string|in:accepted,declined',
                'period_start' => 'required|string',
                'period_end' => 'required|string',
            ]);

            try {
                $application = Application::findOrFail($id);
                $application->update([
                    'status' => $request->status,
                    'period_start' => $request->period_start,
                    'period_end' => $request->period_end,
                ]);

                return new ApplicationResource($application);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Application with ' . $id . ' not found.'
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
                Application::findOrFail($id)->delete();
    
                return response()->json([], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Application with' . $id . ' not found.'
                ], 404);
            }
        }
    }
}
