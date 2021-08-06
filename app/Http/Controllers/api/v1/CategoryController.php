<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();

        return response()->json($category);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(),[
            'category_name' => 'required|min:3|max:100|regex:/^[\pL\s]+$/u|unique:categorys,category_name'
        ],
        [
            'regex'=>"Category name allow only alphabet,space" 
        ]);

        if($Validator->fails())
        {
            return Response()->json(['error'=>$Validator->errors()->all()]);
        }else{
            $categorydata = new Category();
            $categorydata->category_name = $request->category_name;
            $categorydata->parent_category_id  = $request->Category;
            $categorydata->save();

            return Response()->json(["success"=>"Data Inserted Successfully"]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Validator = Validator::make($request->all(),[
            'category_name' => 'required|min:3|max:100|regex:/^[\pL\s]+$/u|unique:categorys,category_name,'.$id
        ]);

        if($Validator->fails())
        {
            return Response()->json(["error"=>$Validator->errors()->all()]);
        }
        $category_data = Category::where('id','=',$id)->first();
        $category_data->category_name = $request->category_name;
        $category_data->parent_category_id = $request->edit_category;
        $category_data->save();

        return Response()->json(["success"=> "Data Updated Successfully" ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Category::where('id','=',$id)->delete();
            return Response()->json(['success' => 'Record Deleted Successfully']);
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Category directly , First delete a related records ']);
        }
    }
}
