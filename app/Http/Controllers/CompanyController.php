<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function PHPSTORM_META\type;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }

    public function companyByUser($userId)
    {
        try {
            if ($userId) {
                return new CompanyResource(Company::where('user_id', '=', (int) $userId)->first());
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Company with user_id ' . $userId . ' not found.'
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone'=> 'required|string',
            'website' => 'nullable|string',
            'description' => 'required|string',
            'number_of_employee' => 'required|integer'
        ]);

        try {
            $company = Company::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'address' => $request->address,
                'phone'=> $request->phone,
                'website' => $request->website,
                'description' => $request->description,
                'number_of_employee' => $request->number_of_employee
            ]);

            return response()->json([$company], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Company creation failed.'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new CompanyResource(Company::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Company with id ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone'=> 'required|string',
            'website' => 'nullable|string',
            'description' => 'required|string',
            'number_of_employee' => 'required|integer'
        ]);

        try {
            $company = Company::findOrFail($id);
            $company->update([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'address' => $request->address,
                'phone'=> $request->phone,
                'website' => $request->website,
                'description' => $request->description,
                'number_of_employee' => $request->number_of_employee,
                // 'logo' => $this->uploadLogo($request, $id)
            ]);

            return new CompanyResource($company);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Company with id ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Company::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                'description' => 'Company with id ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Company with id ' . $id . ' not found.'
            ], 404);
        }
    }

    public function uploadLogo(Request $request, $id)
    {
        try {
            if ($request->logo != null) {
                $request->validate([
                    'logo' => ['mimes:png,jpg,jpeg', 'max:2048'],
                ]);
        
                $data = Company::findOrFail($id);
                $imageName = $request->id . "-" . "companyLogo" . "." . $request->logo->extension();
                $path = public_path('company-logo/');
                $request->logo->move($path, $imageName);
                $image = "company-logo/" . $imageName;
                $data->logo = $image;
                $data->save();
        
                return response()->json([
                    'code' => 200,
                    'message' => 'Image Successfully Updated',
                    'data' => new CompanyResource($data)
                ]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
