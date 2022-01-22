<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chapter = Chapter::query();
        $courseId = $request->query("course_id");

        $chapter->when($courseId, function ($query) use ($courseId) {
            return $query->where("course_id", "=", $courseId);
        });

        return response()->json(Response::apiResponse("Success get all chapter", "success", 200, $chapter->get()), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChapterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "required|string",
            "course_id" => "required|integer"
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }

        $course = Course::find($request->input("course_id"));

        if (!$course) {
            return response()->json(Response::apiResponseNotFound("Course not found"), 404);
        }

        $chapter = Chapter::create($data);

        return response()->json(Response::apiResponse("Success add chapter", "success", 200, $chapter), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(Response::apiResponseNotFound("Chapter not found"), 404);
        }

        return response()->json(Response::apiResponse("Success get chapter", "success", 200, $chapter), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChapterRequest  $request
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "string",
            "course_id" => "integer"
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }
        if ($request->input("course_id")) {
            $course = Course::find($request->input("course_id"));

            if (!$course) {
                return response()->json(Response::apiResponseNotFound("Course not found"), 404);
            }
        }

        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(Response::apiResponseNotFound("Chapter not found"), 404);
        }


        $chapter->fill($data);

        $chapter->save();

        return response()->json(Response::apiResponse("Success update chapter", "success", 200, $chapter), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(Response::apiResponseNotFound("Chapter not found"), 404);
        }

        $chapter->delete();

        return response()->json(Response::apiResponse("Success update chapter", "success", 200, ["message" => "Chapter deleted"]), 200);
    }
}
