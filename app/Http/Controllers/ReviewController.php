<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Helper\Url;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "course_id" => "required|integer",
            "user_id" => "required|integer",
            "rating" => "required|integer|min:1|max:5",
            "note" => "string"
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

        $user = Url::getUser($request->input("user_id"));

        if ($user["meta"]["status"] == 'error') {
            return response()->json(Response::apiResponse($user["meta"]["message"], $user["meta"]["status"], $user["meta"]["code"], ["message" => "Internal Server Error"]), 500);
        }

        $isExistsReview = Review::where("user_id", "=", $request->input("user_id"))->where("course_id", "=", $request->input("course_id"))->exists();

        if ($isExistsReview) {
            return response()->json(Response::apiResponseConflict("review already exists"), 409);
        }

        $review = Review::create($data);

        return response()->json(Response::apiResponse("Success add review", "success", 200, $review), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReviewRequest  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "rating" => "integer|min:1|max:5",
            "note" => "string"
        ];

        $data = $request->except('user_id', "course_id");

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(Response::apiResponseBadRequest($validator->errors()), 400);
        }

        $review = Review::find($id);

        if (!$review) {
            return response()->json(Response::apiResponseNotFound("Review not found"), 404);
        }

        $review->fill($data);
        $review->save();

        return response()->json(Response::apiResponse("Success update review", "success", 200, $review), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(Response::apiResponseNotFound("Review not found"), 404);
        }

        $review->delete();

        return response()->json(Response::apiResponse("Success delete review", "success", 200, ["message" => "Review deleted"]), 200);
    }
}
