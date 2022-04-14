<?php

namespace App\Http\Controllers;

use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VacancyResource::collection(Vacancy::all());
    }

    public function vacancyByUser($userId)
    {
        try {
            $company = Company::where('user_id', '=', $userId)->first();
            
            return VacancyResource::collection(Vacancy::where('company_id', $company->id)->get());
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Vacancy with company_id ' . $company->id . ' not found.'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'nullable|string',
            'sector'=> 'required|string',
            'type' => 'required',
            'paid' => 'required',
            'period_start' => 'required',
            'period_end' => 'required'
        ]);

        try {
            $company = Company::where('user_id', '=', $userId)->first();
            
            $vacancy = Vacancy::create([
                'company_id' => $company->id,
                'name' => $request->name,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'location' => $request->location,
                'sector'=> $request->sector,
                'type' => $request->type,
                'paid' => $request->paid,
                'period_start' => $request->period_start,
                'period_end' => $request->period_end
            ]);

            return response()->json([$vacancy], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Vacancy creation failed.'
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
            return new VacancyResource(Vacancy::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Vacancy with id ' . $id . ' not found.'
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
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'nullable|string',
            'sector'=> 'required|string',
            'type' => 'required',
            'paid' => 'required',
            'period_start' => 'required',
            'period_end' => 'required'
        ]);

        try {
            $vacancy = Vacancy::findOrFail($id);
            $vacancy->update([
                'company_id' => $request->company_id,
                'name' => $request->name,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'location' => $request->location,
                'sector'=> $request->sector,
                'type' => $request->type,
                'paid' => $request->paid,
                'period_start' => $request->period_start,
                'period_end' => $request->period_end
            ]);

            return new VacancyResource($vacancy);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Vacancy creation failed.'
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
            Vacancy::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                'description' => 'Vacancy with id ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Vacancy with id ' . $id . ' not found.'
            ], 404);
        }
    }
}
