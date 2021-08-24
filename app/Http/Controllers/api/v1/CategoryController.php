<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function categoryDetails()
    {
        $category = Category::all();
        return Response()->json(["status"=> true,"category" => $category]); 
    }
}
