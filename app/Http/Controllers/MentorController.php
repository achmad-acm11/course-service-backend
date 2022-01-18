<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors = Mentor::all();

        if (count($mentors) == 0) {
            return response()->json(Response::apiResponseNotFound("Mentor is empty"), 404);
        }

        return response()->json(Response::apiResponse("Success Get All Mentors", 'success', 200, $mentors), 200);
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
     * @param  \App\Http\Requests\StoreMentorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "string|required",
            "email" => "email|required",
            "profile" => "required|url",
            "profession" => "string|required"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }

        $mentor = Mentor::create($data);

        return response()->json(Response::apiResponse("Success Create Mentor", "success", 200, $mentor), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json(Response::apiResponseNotFound("Mentor not found"), 404);
        }

        return response()->json(Response::apiResponse("Success Get All Mentors", 'success', 200, $mentor), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function edit(Mentor $mentor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMentorRequest  $request
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|string",
            "email" => "required|email",
            "profile" => "required|url",
            "profession" => "required|string"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }

        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json(Response::apiResponseNotFound("Mentor Not Found"), 404);
        }

        $mentor->fill($data);

        $mentor->save();

        return response()->json(Response::apiResponse("Success Update Mentor", "success", 200, $mentor), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json(Response::apiResponseNotFound("Mentor Not Found"), 404);
        }

        $mentor->delete();

        return response()->json(Response::apiResponse("Success Delete Mentor", "success", 200, ["message" => "Mentor deleted"]), 200);
    }
}
