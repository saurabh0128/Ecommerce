<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $product = Product::all();

        return Response()->json($product);
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
        $validator = Validator::make($request->all(),[
            "product_name" => "required|min:2|max:200",
            "current_price" => "required|max:10",
            "special_price" => "nullable|max:10",
            "product_desc" =>  "required",
            "product_sort_desc" =>  "required",
            "Category" => "required",
            "Seller" => "required",
            "product_image" => "required|image|max:2048",
            "stock" => "required|numeric",
            "is_display" => "required",
            "is_avilable" => "required"
        ],
        [
            "regex"=>"Only number and decimal allowed"
        ]);

        if($validator->fails())
        {
            return Response()->json(["error"=>$validator->errors()->all()]);
        }else{
            $product = new Product();

            $onlyImgName = pathinfo($request->product_image->getClientOriginalName(),PATHINFO_FILENAME);
            $imgExtension = $request->product_image->getClientOriginalExtension(); 
            $imgName = $onlyImgName."-".time().".".$imgExtension;
            $request->product_image->move(public_path('backend_asset/product_images'),$imgName);
            $product->product_img = $imgName;

            // for thumbnail create and save 
            $img = Image::make(public_path('/backend_asset/product_images/'.$imgName));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/product_images/'.$imgName);


            $product->product_name = $request->product_name;
            $product->product_desc = $request->product_desc;
            $product->product_sort_desc = $request->product_sort_desc;
            $product->current_price = $request->current_price;
            $product->special_price = $request->special_price;
            $product->category_id = $request->Category;
            $product->user_id = $request->Seller;
            $product->is_display = $request->is_display;
            $product->is_avilable = $request->is_avilable;
            $product->stock = $request->stock;
            $product->save();

            return Response()->json(['success'=>'Data Inserted Successfully']);
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
        $validator = Validator::make($request->all(),[
            "product_name" => "required|min:2|max:200",
            "current_price" => "required|max:10",
            "special_price" => "nullable|max:10",
            "product_desc" =>  "required",
            "product_sort_desc" =>  "required",
            "Category" => "required",
            "Seller" => "required",
            "product_image" => "image|max:2048",
            "stock" => "required|numeric",
            "is_display" => "required",
            "is_avilable" => "required"
        ],
        [
            "regex"=>"Only number and decimal allowed"
        ]);
        if($validator->fails())
        {
            return Response()->json(["error"=>$validator->errors()->all()]);
        }else{

            $product = Product::where('id','=',$id)->first();

            if($request->hasFile('product_image'))
            {
                $onlyImgName = pathinfo($request->product_image->getClientOriginalName(),PATHINFO_FILENAME);
                $imgExtension = $request->product_image->getClientOriginalExtension(); 
                $imgName = $onlyImgName."-".time().".".$imgExtension;
                $request->product_image->move(public_path('backend_asset/product_images'),$imgName);
                $product->product_img = $imgName;

                // for thumbnail create and save 
                $img = Image::make(public_path('/backend_asset/product_images/'.$imgName));
                $img->resize(150,150);
                $img->save(public_path().'/backend_asset/thumbnail/product_images/'.$imgName);
            }    

            $product->product_name = $request->product_name;
            $product->product_desc = $request->product_desc;
            $product->product_sort_desc = $request->product_sort_desc;
            $product->current_price = $request->current_price;
            $product->special_price = $request->special_price;
            $product->category_id = $request->Category;
            $product->user_id = $request->Seller;
            $product->is_display = $request->is_display;
            $product->is_avilable = $request->is_avilable;
            $product->stock = $request->stock;
            $product->save();

            return Response()->json(['success'=>'Data Updated Successfully']);
        }
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
            Product::where('id','=',$id)->delete();
            return Response()->json(["success"=> 'Data Deleted Successfully']);
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Product directly , First delete a related records ']);
        }
    }
}
