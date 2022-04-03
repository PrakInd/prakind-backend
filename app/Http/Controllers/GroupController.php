<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $this->validate($request, [
            'referral_code' => 'nullable|string'
        ]);

        try {
            $group = Group::create([
                'referral_code' => $this->generateGroupToken()
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new GroupResource(Group::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Group with id ' . $id . ' not found.'
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
            'referral_code' => 'required',
        ]);

        try {
            $group = Group::findOrFail($id);
            $group->update([
                'referral_code' => $request->referral_code
            ]);

            return new GroupResource($group);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Group with id ' . $id . ' not found.'
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
            Group::findOrFail($id)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Successfully Deleted',
                 'description' => 'Group with id ' . $id . ' successfully deleted.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Group with id ' . $id . ' not found.'
            ], 404);
        }
    }

    // public function generateGroupToken()
    // {
    //     $tokenLength = 12;
    //     $str = "1234567890abcdefghijklmnopqrstuvwxyz$";
    //     $randStr = substr(str_shuffle($str), 0, $tokenLength);
    // 
    //     return $randStr;
    // }

    // public function generateGroupToken()
    // {
    //     $randStr = uniqid('rafi', true);
    // 
    //     return $randStr;
    // }
    
    public function generateGroupToken()
    {
        $randStr = uniqid('rafi', true);
    
        return $randStr;
    }
}
