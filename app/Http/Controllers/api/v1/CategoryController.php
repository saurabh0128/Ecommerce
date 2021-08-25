<?php 

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function categoryDetails(Request $request)
    {
        if($request->status == 0 ){
            $category = Category::all();   
        }
        else{
            $category = Category::where('parent_category_id',Null)->get();
        }
        return Response()->json(["status"=> true,"category" => $category]); 
    }
}
