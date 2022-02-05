<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Profile;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $this->validate($request, [
            'address' => 'required|string',
            'phone' => 'required|string',
            'gpa' => 'required|string',
            'semester' => 'required'
        ]);

        try {
            $profile = Profile::create([
                'user_id' => $request->user_id,
                'institution_id' => $request->institution_id,
                'address' => $request->address,
                'phone' => $request->phone,
                'gpa' => $request->gpa,
                'semester' => $request->semester,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new ProfileResource(Profile::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Profile with id ' . $id . ' not found.'
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
        // $this->authorize('update', $id);

        $this->validate($request, [
            'address' => 'required|string',
            'phone' => 'required|string',
            'gpa' => 'required|string',
            'semester' => 'required'
        ]);

        try {
            $profile = Profile::findOrFail($id);
            $profile->update([
                'user_id' => $request->user_id,
                'institution_id' => $request->institution_id,
                'address' => $request->address,
                'phone' => $request->phone,
                'gpa' => $request->gpa,
                'semester' => $request->semester
            ]);

            return new ProfileResource($profile);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Profile with id ' . $id . ' not found.'
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
            Profile::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                 'description' => 'Profile with id ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Profile with id ' . $id . ' not found.'
            ], 404);
        }
    }

    public function uploadDocument(Request $request, $id, $document)
    {
        try {
            $request->validate([
                $this->documentType($document) => ['mimes:pdf', 'max:2048'],
            ]);
    
            $data = Profile::findOrFail($id);
            $fileName = $request->id . "-" . $document . "." . $request->$document->extension();
            $path = public_path('profile-documents/');
            $request->$document->move($path, $fileName);
            $file = "profile-documents/" . $fileName;
            $data->$document = $file;
            $data->save();
    
            return response()->json([
                'code' => 200,
                'data' => new ProfileResource($data)
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function documentType($doc)
    {
        if ($doc == 'cv') return 'cv';
        if ($doc == 'transcript') return 'transcript';

        return 'portfolio';
    }
}
