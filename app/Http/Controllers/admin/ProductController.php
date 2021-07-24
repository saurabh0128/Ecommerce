<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\User;

use Illuminate\Database\QueryException;

use App\Models\Product;


use Validator;

use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys = Category::all();
        $sellers = User::where('user_status','=',1)->get();

        return view('backend.product.create',compact('categorys','sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "product_name" => "required|min:2|max:200",
            "current_price" => "required|regex:/^\d+(\.\d{1,2})?$/|max:8",
            "special_price" => "required|regex:/^\d+(\.\d{1,2})?$/|max:8",
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


        $onlyImgName = pathinfo($request->product_image->getClientOriginalName(),PATHINFO_FILENAME);
        $imgExtension = $request->product_image->getClientOriginalExtension(); 
        $imgName = $onlyImgName."-".time().".".$imgExtension;
        $request->product_image->move(public_path('backend_asset/product_images'),$imgName);

        $product = new Product();
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
        $product->product_img = $imgName;
        $product->save();

        return redirect()->route('admin.product.index')->with("success","Data Inserted Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // DB::enableQueryLog();
        $product = Product::with(['category','user'])->where('id','=',$id)->firstOrFail();
        // dd($product);
        return view('backend.product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = Product::where('id','=',$id)->firstOrFail();
        $categorys = Category::all();
        $sellers = User::where('user_status','=',1)->get();
        return view('backend.product.edit',compact('categorys','sellers','product'));
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
        $request->validate([
            "product_name" => "required|min:2|max:200",
            "current_price" => "required|regex:/^\d+(\.\d{1,2})?$/|max:8",
            "special_price" => "required|regex:/^\d+(\.\d{1,2})?$/|max:8",
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

        $product = Product::where('id','=',$id)->first();

        if($request->hasFile('product_image'))
        {
            $onlyImgName = pathinfo($request->product_image->getClientOriginalName(),PATHINFO_FILENAME);
            $imgExtension = $request->product_image->getClientOriginalExtension(); 
            $imgName = $onlyImgName."-".time().".".$imgExtension;
            $request->product_image->move(public_path('backend_asset/product_images'),$imgName);
            $product->product_img = $imgName;
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

        return redirect()->route('admin.product.index')->with("success","Data Updated Successfully");
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
        } catch (QueryException $e) {
             return Response()->json(["error"=> 'You cannot delete a Product directly , First delete a related records ']);
        }
    }

    public function ajax(Request $request)
    {

       // $sk = Product::with('category')->first();
       // dd($sk);

        if($request->ajax()|| $request->mode == 'datatable'){

            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); 


             $columnIndex_arr = $request->get('order');
             $columnName_arr = $request->get('columns');
             $order_arr = $request->get('order');
             $search_arr = $request->get('search');

             $columnIndex = $columnIndex_arr[0]['column']; // Column index
             $columnName = $columnName_arr[$columnIndex]['data']; // Column name
             $columnSortOrder = $order_arr[0]['dir']; // asc or desc
             $searchValue = $search_arr['value']; // Search value

             // Total records
             $totalRecords = Product::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Product::select('count(*) as allcount')->where('product_name', 'like', '%' .$searchValue . '%')->count();

             // DB::enableQueryLog();
             // Fetch records
             $records = Product::with('category')->orderBy($columnName,$columnSortOrder)
               ->where('Products.product_name', 'like', '%' .$searchValue . '%')
               ->select('Products.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();
            // dd(DB::getQueryLog());


              //for a where condition on  a  categoryname 
             //   array('category' => function($query){
             //       $query->where('Categorys.category_name','like','%123%'); 
             // })


                // dd($records->toArray()); 
             $data_arr = array();

             //for a counter 
             $count = 1;

             foreach($records as $record){
                $id = $record->id;
                $product_name = $record->product_name;
                $product_img = $record->product_img;
                $price = $record->special_price;
                $category = $record->category->category_name;
                $stock = $record->stock;

                $data_arr[] = array(
                  "id" => $count,
                  "product name" => $product_name,
                  "product image"=>  '<img src="'.asset('/backend_asset/product_images/'.$product_img).'" alt="product image" height="100" width="100" >' ,
                  "category" =>$category,
                  "price" => $price,
                  "stock" => $stock,
                  "action" => '<a href="'.route('admin.product.show',$id).'"> <button type="button" class="btn btn-sm btn-warning" >View </button></a>  <a href="'.route('admin.product.edit',$id).'"><button type="button" id="EditBtn" class="btn btn-sm btn-info" >Edit</button></a> <button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button>'
                );
                $count++;
             }

             $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
             );

             echo json_encode($response);
             exit;
        }     
    }
}
