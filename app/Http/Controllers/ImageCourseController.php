<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Http\Requests\StoreImageCourseRequest;
use App\Http\Requests\UpdateImageCourseRequest;
use App\Models\Course;
use App\Models\ImageCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\Http\Requests\StoreImageCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "image" => "required|url",
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

        $imageCourse = ImageCourse::create($data);
        return response()->json(Response::apiResponse("Success add image", "success", 200, $imageCourse), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function show(ImageCourse $imageCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageCourse $imageCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImageCourseRequest  $request
     * @param  \App\Models\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageCourseRequest $request, ImageCourse $imageCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imageCourse = ImageCourse::find($id);

        if (!$imageCourse) {
            return response()->json(Response::apiResponseNotFound("Image Course not found"), 200);
        }
        $imageCourse->delete();
        return response()->json(Response::apiResponse("Success delete image", "success", 200, ["message" => "Image Deleted"]), 200);
    }
}
