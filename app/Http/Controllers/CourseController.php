<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::query();

        $q = $request->query("q");
        $status = $request->query("status");

        $courses->when($q, function ($query) use ($q) {
            return $query->whereRaw("name LIKE '%" . strtolower($q) . "%'");
        });

        $courses->when($status, function ($query) use ($status) {
            return $query->where("status", "=", $status);
        });

        return response()->json(Response::apiResponse("Success get all courses", "success", 200, $courses->paginate(10)), 200);
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
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "required|string",
            "certificate" => "required|boolean",
            "thumbnail" => "string|url",
            "type" => "required|in:free,premium",
            "status" => "required|in:draft,publish",
            "price" => "integer",
            "level" => "required|in:all-level,beginner,intermediate,advance",
            "mentor_id" => "required|integer",
            "description" => "string"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }

        $mentor_id = $request->input("mentor_id");

        $mentor = Mentor::find($mentor_id);

        if (!$mentor) {
            return response()->json(Response::apiResponseNotFound("Mentor not found"), 404);
        }

        $course = Course::create($data);

        return response()->json(Response::apiResponse("Success create course", "success", 200, $course), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with(["mentor", "chapter"])->find($id);

        if (!$course) {
            return response()->json(Response::apiResponseNotFound("Course not found"), 404);
        }

        return response()->json(Response::apiResponse("Success get course", "success", 200, $course), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|string",
            "certificate" => "required|boolean",
            "thumbnail" => "string|url",
            "type" => "required|in:free,premium",
            "status" => "required|in:draft,publish",
            "price" => "integer",
            "level" => "required|in:all-level,beginner,intermediate,advance",
            "mentor_id" => "required|integer",
            "description" => "string"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }

        $mentor_id = $request->input("mentor_id");

        $mentor = Mentor::find($mentor_id);

        if (!$mentor) {
            return response()->json(Response::apiResponseNotFound("Mentor not found"), 404);
        }

        $course = Course::with("mentor")->find($id);

        if (!$course) {
            return response()->json(Response::apiResponseNotFound("Course not found"), 404);
        }

        $course->fill($data);

        $course->save();

        return response()->json(Response::apiResponse("Success update course", "success", 200, $course), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::with("mentor")->find($id);

        if (!$course) {
            return response()->json(Response::apiResponseNotFound("Course not found"), 404);
        }

        $course->delete();

        return response()->json(Response::apiResponse("Success delete course", "success", 200, ["message" => "Course deleted"]), 200);
    }
}
