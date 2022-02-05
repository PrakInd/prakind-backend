<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Application;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $this->validate($request, [
            'status' => 'required|string',
            'period_start' => 'required|string',
            'period_end' => 'required|string'
        ]);

        try {
            $application = Application::create([
                'profile_id' => $request->profile_id,
                'group_id' => $request->group_id,
                'vacancy_id' => $request->vacancy_id,
                'status' => $request->status,
                'period_start' => $request->period_start,
                'period_end' => $request->period_end,
            ]);

            return response()->json([$application], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Application creation failed.'
            ], 404);
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
            return new ApplicationResource(Application::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Application with id ' . $id . ' not found.'
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
            'status' => 'required|string',
            'period_start' => 'required|string',
            'period_end' => 'required|string'
        ]);

        try {
            $application = Application::findOrFail($id);
            $application->update([
                'profile_id' => $request->profile_id,
                'group_id' => $request->group_id,
                'vacancy_id' => $request->vacancy_id,
                'status' => $request->status,
                'period_start' => $request->period_start,
                'period_end' => $request->period_end
            ]);

            return new ApplicationResource($application);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Application with id ' . $id . ' not found.'
            ], 404);
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
            Application::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                'description' => 'Application with id ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Application with' . $id . ' not found.'
            ], 404);
        }
    }

    public function uploadCertificate(Request $request, $id)
    {
        try {
            $request->validate([
                'certificate' => ['mimes:pdf', 'max:2048'],
            ]);
    
            $data = Application::findOrFail($id);
            $fileName = $request->id . "-certificate" . "." . $request->certificate->extension();
            $path = public_path('application-certificates/');
            $request->certificate->move($path, $fileName);
            $file = "application-certificates/" . $fileName;
            $data->certificate = $file;
            $data->save();
    
            return response()->json([
                'code' => 200,
                'data' => new ApplicationResource($data)
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
