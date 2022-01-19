<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Http\Requests\StoreMyCourseRequest;
use App\Http\Requests\UpdateMyCourseRequest;
use App\Models\Course;
use App\Models\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myCourse = MyCourse::query();

        $userId = $request->query("user_id");
        $myCourse->when($userId, function ($query) use ($userId) {
            return $query->where("user_id", "=", $userId);
        });

        return response()->json(Response::apiResponse("Success get My Course", "success", 200, $myCourse->get()), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPremiumAccess(Request $request)
    {
        $data = $request->all();
        $myCourse = MyCourse::create($data);

        return response()->json(Response::apiResponse("Success create Course premium access", "success", 200, $myCourse), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMyCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "user_id" => "required|integer",
            "course_id" => "required|integer"
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 200);
        }

        $course = Course::find($request->input("course_id"));
        if (!$course) {
            return response()->json(Response::apiResponseNotFound("Course not found"), 200);
        }

        $user = getUser($request->input("user_id"));

        if ($user["status"] == 'error') {
            return response()->json(Response::apiResponse($user["message"], $user["status"], $user["code"], ["message" => "Internal Server Error"]), 500);
        }

        $isExistCourse = MyCourse::where("user_id", "=", $request->input("user_id"))->where("course_id", "=", $request->input("course_id"))->exists();

        if ($isExistCourse) {
            return response()->json(Response::apiResponseConflict("user already take this course"), 409);
        }

        if ($course->type === "premium") {
            if ($course->price === 0) {
                return response()->json(Response::apiResponseMethodNotAllowed("Price can't be 0"), 405);
            }
        } else {
            $myCourse = MyCourse::create($data);
            return response()->json(Response::apiResponse("Success add course", "success", 200, $myCourse), 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function show(MyCourse $myCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(MyCourse $myCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMyCourseRequest  $request
     * @param  \App\Models\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyCourseRequest $request, MyCourse $myCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyCourse $myCourse)
    {
        //
    }
}
