<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicantFileResource;
use App\Models\ApplicantFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicantFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApplicantFileResource::collection(ApplicantFile::all());
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
                $applicant_file = ApplicantFile::create([
                    'application_id' => $request->application_id,
                    'recommendation_letter' => $request->recommendation_letter,
                    'proposal' => $request->proposal,
                ]);

                return response()->json([$applicant_file], 201);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Application file creation failed.'
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
                return new ApplicantFileResource(ApplicantFile::findOrFail($id));
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
                'recommendation_letter' => 'required',
                'proposal' => 'required',
            ]);

            try {
                $applicant_file = ApplicantFile::findOrFail($id);
                $applicant_file->update($request->all());

                return new ApplicantFileResource($applicant_file);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Applicant file with ' . $id . ' not found.'
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
                ApplicantFile::findOrFail($id)->delete();
    
                return response()->json([], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found',
                    'description' => 'Applicant file with' . $id . ' not found.'
                ], 404);
            }
        }
    }
}
