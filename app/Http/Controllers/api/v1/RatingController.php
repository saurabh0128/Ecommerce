<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RatingReview;

class RatingController extends Controller
{
    public function userRating(Request $request)
    {
        $rating = new RatingReview;

        $rating->user_id = Auth('api')->id();
        $rating->product_id = $request->product_id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->is_display = 1;

        $rating->save();

        return Response()->json(["success" => "Thanks For Rating and Review"]);
    }
}
