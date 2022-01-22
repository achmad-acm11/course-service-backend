<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use App\Helper\Response;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lessons = Lesson::query();
        $chapterId = $request->query("chapter_id");

        $lessons->when($chapterId, function ($query) use ($chapterId) {
            return $query->where("chapter_id", "=", $chapterId);
        });

        return response()->json(Response::apiResponse("Success get all lessons", "success", 200, $lessons->get()), 200);
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
     * @param  \App\Http\Requests\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "required|string",
            "video" => "required|string",
            "chapter_id" => "required|integer"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 200);
        }

        $chapter = Chapter::find($request->input("chapter_id"));
        if (!$chapter) {
            return response()->json(Response::apiResponseNotFound("Chapter not found"), 200);
        }

        $lesson = Lesson::create($data);

        return response()->json(Response::apiResponse("Success add lesson", "success", 200, $lesson), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json(Response::apiResponseNotFound("Lesson not found"), 404);
        }

        return response()->json(Response::apiResponse("Success get lesson", "success", 200, $lesson), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLessonRequest  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "string",
            "video" => "string",
            "chapter_id" => "integer"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 200);
        }

        if ($request->input("chapter_id")) {
            $chapter = Chapter::find($request->input("chapter_id"));
            if (!$chapter) {
                return response()->json(Response::apiResponseNotFound("Chapter not found"), 200);
            }
        }

        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json(Response::apiResponseNotFound("Lesson not found"), 404);
        }

        $lesson->fill($data);

        $lesson->save();

        return response()->json(Response::apiResponse("Success Update lesson", "success", 200, $lesson), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json(Response::apiResponseNotFound("Lesson not found"), 404);
        }

        $lesson->delete();

        return response()->json(Response::apiResponse("Success Delete lesson", "success", 200, ["message" => "Lesson deleted"]), 200);
    }
}
