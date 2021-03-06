<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userwishlist = Wishlist::with('product')->where('user_id',auth('api')->id())->get();
       
        foreach($userwishlist as $key => $list){
            if($list->product->is_display == 1){
                unset($userwishlist[$key]);
                Wishlist::find($list->id)->delete();
                // continue;   
            }  
        }
        return Response()->json($userwishlist);
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
        $userwishlist = Wishlist::where('user_id',auth('api')->id())->where('product_id',$request->product_id)->first();
         // echo auth('api')->id();
        if($userwishlist){
            return Response()->json(["Sccess" => "Product Add SuccessFully"]);
        }else{
            
            $addWishlist = new Wishlist;

            $addWishlist->user_id = auth('api')->id();
            $addWishlist->product_id = $request->product_id;
            
            $addWishlist->save();

            return Response()->json(["Sccess" => "Product Add SuccessFully"]);
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
        $item_delete = Wishlist::where('user_id',auth('api')->id())->where('id',$id)->first();

        if($item_delete){
            Wishlist::find($id)->delete();

            return Response()->json(["Success" => "Product Deleted"]);
        }else{
            return Response()->json(["Success" => "Product Deleted"]);    
        }
                
    }
}
