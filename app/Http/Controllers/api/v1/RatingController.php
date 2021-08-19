<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RatingReview;
use App\Models\Product;
use DB;

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

        $avg_rating = RatingReview::where('product_id',$request->product_id)
        ->select(DB::raw('AVG(rating_reviews.rating) as avrage_rating '))
        ->groupBy('product_id')
        ->first();

        $product = Product::where('id',$request->product_id)->first();
        $product->rating = $avg_rating->avrage_rating;
        $product->save();

        return Response()->json(["success" => "Thanks For Rating and Review"]);
    }
}
