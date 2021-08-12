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

        if(is_null($cartdata)){

            $cart = new Cart;
            $product_data = Product::find($request->product_id);
            $cart_item = new CartItem;

            $cart->user_id = auth('api')->id();
            $cart->shipping_charges = 1500;
            $cart->subtotal = 0;
            $cart->total = 0;
            $cart->save();


            $cart->subtotal = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
            if(isset($request->coupon_code)){
                $coupon = Coupone::where('coupon_code',$request->coupon_code)->firstOrFail();
                $cart->coupon_code =[
                   "coupon1" => $request->coupon_code
                ];
               
                //dd($code);
                $price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                
                if($coupon->discount_type == "Rupees"){
                    $cart->discount = $coupon->coupon_discount;
                    $discount = $coupon->coupon_discount;
                }elseif($coupon->discount_type == "Percentage"){
                    $cart->discount = $coupon->coupon_discount;
                    $discount = $price/100*$coupon->coupon_discount;
                }   
                $cart->total = $price-$discount+$cart->shipping_charges;
                // return Response($cart->total);
            }else{
                $cart->total = $cart->subtotal+$cart->shipping_charges;
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
            $cart = Cart::where('user_id',auth('api')->id())->firstOrFail();
            $product_data =  Product::find($request->product_id);
            $cart_item = new CartItem;

            $cart_item->cart_id = $cart->id;
            $cart_item->product_id = $request->product_id;
            $cart_item->name = $product_data->product_name;
            $cart_item->price =  isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
            $cart_item->image = $product_data->product_img;
            $cart_item->quantity = 1 ;

           // $cart_item->save();

            $cart->subtotal += isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;



            if(isset($request->coupon_code)){
                $coupon = Coupone::where('coupon_code',$request->coupon_code)->firstOrFail();
                $user_coupon = Cart::where('user_id',auth('api')->id())->first();

                $code = count($user_coupon->coupon_code);
                //$coupon->coupon_code = array_push($code,$request->coupon_code);
                $old_code = $user_coupon->coupon_code;
                array_push($old_code,["coupon".$code => $request->coupon_code]);
                //dd($code);
                $cart->coupon_code = $old_code;
                $price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                
                if($coupon->discount_type == "Rupees"){
                    $cart->discount += $coupon->coupon_discount;
                    $discount = $coupon->coupon_discount;
                }elseif($coupon->discount_type == "Percentage"){
                    $cart->discount += $coupon->coupon_discount;
                    $discount = $price/100*$coupon->coupon_discount;
                }   
                $cart->total += $price-$discount;
                // return Response($cart->total);
            }else{

                $cart->total += isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
            }
            $cart->save();

            return Response()->json(["success" => "Product Add SuccessFully"]);
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
        $cart = Cart::with('CartItem','Coupone')->where('id',$id)->get();

        return Response($cart);
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
        $cart = Cart::where('user_id','=',auth('api')->id())->firstOrFail();
        $cart_item = CartItem::find($id);
       
        if($request->quantity > $cart_item->quantity){
            
            $price = $cart_item->price*($request->quantity-$cart_item->quantity);
            $cart_item->quantity = $request->quantity;
            $cart->subtotal += $price;
            $cart->total += $price;
            
            $cart_item->save();
            $cart->save();

            return Response()->json(["success" => "Quantity Updated Successfully"]);
            
        }else{
            
            $price = $cart_item->price*($cart_item->quantity-$request->quantity);
            $cart_item->quantity = $request->quantity;
            $cart->subtotal -= $price;
            $cart->total -= $price;
            
            $cart_item->save();
            $cart->save();

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
        $cart_item = CartItem::find($id);
        $cart = Cart::where('user_id',auth('api')->id())->firstOrFail();

        $price = $cart_item->price*$cart_item->quantity;
        $cart->subtotal -= $price;
        $cart->total -= $price;
        // dd($cart->total);
        $cart->save();

        $cart_item = CartItem::find($id)->delete();

        return Response()->json(["success" => "Product Delete Successfully"]);
    }
}
