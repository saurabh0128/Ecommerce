<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Coupone;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $cartdata =Cart::where('user_id','=',auth('api')->id())->first();
        //User Create new cart Or Not
        if(is_null($cartdata)){
            $cart = new Cart;
            $product_data = Product::find($request->product_id);
            $cart_item = new CartItem;
            
            $cart->user_id = auth('api')->id();
            $cart->shipping_charges = 1500;
            $cart->save();
            //User apply Any Coupon Or Not
            if(isset($request->coupon_code)){
                $coupon = Coupone::where('coupon_code',$request->coupon_code)->first();
                $cart->coupon_code =[
                   $request->product_id => $request->coupon_code
                ];
                $price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                //chaeck Discount Type is Rupees Or Percentafes
                if($coupon->discount_type == "fixed"){
                    $cart->discount = $coupon->coupon_discount;       
                }elseif($coupon->discount_type == "Percentage"){
                    $discount = $price/100*$coupon->coupon_discount;
                    $cart->discount = $discount;
                }
            }

            $cart->save();

            $cart_item->cart_id = $cart->id;
            $cart_item->product_id = $request->product_id;
            $cart_item->name = $product_data->product_name;
            $cart_item->price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
            $cart_item->image = $product_data->product_img;
            $cart_item->quantity = 1;

            $cart_item->save();

            return Response()->json(["success" => "Product Add SuccessFully"]);
        }else{
            //Old User Cart
            $cart = Cart::where('user_id',auth('api')->id())->first();
            $product_data =  Product::find($request->product_id);
            $Old_product = CartItem::where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
                  
            //User Add New Peoduct Or Not
            if(is_null($Old_product))
            {   //User Add New Product
                $cart_item = new CartItem;
                
                $cart_item->cart_id = $cart->id;
                $cart_item->product_id = $request->product_id;
                $cart_item->name = $product_data->product_name;
                $cart_item->price =  isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                $cart_item->image = $product_data->product_img;
                $cart_item->quantity = 1;

                $cart_item->save();
                //if add coupan discount write
                $cart->discount = 0;
                $cart->coupon_code = 0;
                $cart->save();

                return Response()->json(["success" => "Product Add SuccessFully"]);
               
            }else{//User Add Old Product
                //if tha coupon Enter Or Not                
                //USer Coupon Not Enter
                $product = CartItem::where('cart_id',$cart->id)->where('product_id',"=",$request->product_id)->first(); 
                $product->quantity += 1; 
                
                $cart->discount = 0;
                $cart->coupon_code = 0;
                $cart->save();

                $product->save();

                return Response()->json(["success" => "Product Add SuccessFully"]);   
            }

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
        $cart = Cart::with('CartItem')->where('id',$id)->first();
     
        return Response()->json(['cart' => $cart]);
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
    public function update(Request $request,$id)
    {
        $cart = Cart::where('user_id','=',auth('api')->id())->first();
        $cart_item = CartItem::find($id);
       
        if($request->quantity > $cart_item->quantity){
            $cart_item->quantity = $request->quantity;
            
            $cart->discount = 0;
            $cart->coupon_code = 0;
            $cart->save();

            $cart_item->save();
            return Response()->json(["success" => "Quantity Updated Successfully"]); 
        }else{
            $cart_item->quantity = $request->quantity;
            
            $cart->discount = 0;
            $cart->coupon_code = 0;
            $cart->save();

            $cart_item->save();
            return Response()->json(["success" => "Quantity Updated Successfully"]);
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
        CartItem::find($id)->delete();

        return Response()->json(["success" => "Product Delete Successfully"]);
    }
}
