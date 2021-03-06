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

        //get a product as per the filter
        $query = Product::with('category','rating_review','purchase_item');

        //sorting for latest product
        if(request('sorting') == "date"){
            $query->latest();
        }
        //sorting for low to high product
        if(request('sorting') == "ltoh"){
            $query->orderBy('current_price');
        }
        //sorting for high to low  product
        if(request('sorting') == "htol"){
            $query->orderBy('current_price','DESC');
        }
        //sorting for avrage rating
        if(request('sorting') == "rating"){
            $query->orderBy('rating','DESC');
        }

        // sorting for poppular product
        if(request('sorting') == "popularity"){ 
            $query->orderBy('total_order','DESC');
        }

        //min max fiter
        if(request('min')){
            $query->where('current_price','>=',request('min')); 
        }
        if(request('max')){
            $query->Where('current_price','<=',request('max')); 
        }

        //category filter filrest check for category other wise check for parent category
        if(request('category')){
            //inner join for category or sub category wise product
            $query->whereIn('category_id',function($q){
                $q->select('id')
                ->from(with('categorys'))
                ->where('id',request('category'))
                ->orWhere('parent_category_id',request('category'));
            });   
        }
        if(request('seller')){
            $query->whereIn('user_id',request('seller'));
        }

        $product = $query->paginate(request('per_page'));
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

        return Response()->json(["status"=> true,"product" => $product]);
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
