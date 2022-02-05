<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ApplicantFile;
use App\Http\Resources\ApplicantFileResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $applicant_file = ApplicantFile::create([
                'application_id' => $request->application_id,
                'recommendation_letter' => $request->recommendation_letter,
                'proposal' => $request->proposal
            ]);

            return response()->json([$applicant_file], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Applicant file creation failed.'
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
            return new ApplicantFileResource(ApplicantFile::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Applicant file with id ' . $id . ' not found.'
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
        //
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
            ApplicantFile::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                'description' => 'Applicant file with id ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Applicant file with id ' . $id . ' not found.'
            ], 404);
        }
    }

    public function uploadDocument(Request $request, $id, $document)
    {
        try {
            $request->validate([
                $this->documentType($document) => ['mimes:pdf', 'max:2048'],
            ]);
    
            $data = ApplicantFile::findOrFail($id);
            $fileName = $request->id . "-" . $document . "." . $request->$document->extension();
            $path = public_path('applicant-files/');
            $request->$document->move($path, $fileName);
            $file = "applicant-files/" . $fileName;
            $data->$document = $file;
            $data->save();
    
            return response()->json([
                'code' => 200,
                'data' => new ApplicantFileResource($data)
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function documentType($doc)
    {
        if ($doc == 'recommendation-letter') return 'recommendation_letter';
        
        return 'proposal';
    }
}
