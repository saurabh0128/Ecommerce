<?php
namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Validator;
use Image;
use DB;


class ProductController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //  Product::addToCart($request->id);
        $query = Product::with('category','rating_review','purchase_item');

        if(request('sorting') == "date"){
            $query->latest();
        }
        if(request('sorting') == "ltoh"){
            $query->orderBy('current_price');
        }
        if(request('sorting') == "htol"){
            $query->orderBy('current_price','DESC');
        }
        if(request('sorting') == "rating"){
            $query->orderBy('rating','DESC');
        }
        if(request('sorting') == "popularity"){ 
            $query->orderBy('total_order','DESC');
        }
        if(request('min')){
            $query->where('current_price','>=',request('min')); 
        }
        if(request('max')){
            $query->Where('current_price','<=',request('max')); 
        }

        $product = $query->get();
        return Response()->json(["status"=> true,"product" => $product]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('user','rating_review')->findOrFail($id);

        return Response()->json($product);
    
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
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
