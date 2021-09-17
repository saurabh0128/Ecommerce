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
        $cart = Cart::with('CartItem')->where('user_id',auth('api')->id())->first();
     
        return Response()->json(['status'=>true,'cart' => $cart]);
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
        // go to if user not exist
        if(!(auth('api')->id()))
        {
            // get proidyct using product id
            $product_data = Product::select('id','product_name as name','current_price','special_price','product_img as image')->find($request->productData['id'])->toArray();
            // set a price if special price exist it is main price otherwise current price
            if($product_data['special_price'])
            {
                $product_data['price'] = $product_data['special_price'];
                unset($product_data['special_price']);
            }
            else{
                $product_data['price'] = $product_data['current_price'];
                unset($product_data['current_price']);
            }
            $product_data['quantity'] = $request->productData['quantity'];
            return Response()->json(["status" => false,'productData'=>$product_data]);
        } 
        //User Create new cart Or Not
        elseif(is_null(Cart::where('user_id','=',auth('api')->id())->first())){

            // if it is multiple Products
            if(array_keys($request->productData) === range(0, count($request->productData) - 1))
            {
                // get a first product of product data in FirstElement
                $FirstElement = array_reverse($request->productData);
                $FirstElement = array_pop($FirstElement);
                foreach($request->productData as $product)
                {
                    if($FirstElement == $product)
                    {
                        $response = AddNewProductToCart(json_decode($product,true));
                    }
                    else
                    {
                       $response = AddProductToCart(json_decode($product,true));
                    }
                }
                return $response;
            }
            // if it is single product
            else
            {
                $response = AddNewProductToCart($request->productData);
                return $response;
            }    
        }else{
            //Old Cart (Update Cart)
            if(array_keys($request->productData) === range(0, count($request->productData) - 1))
            {
                foreach($request->productData as $product)
                {
                    if(is_array($product))
                    {
                        // print_r($product);
                        $response = AddProductToCart($product);
                    }
                    else{
                        // print_r($product);
                        $response = AddProductToCart(json_decode($product,true));
                    }
                }
                return $response;
            }   
            else    
            {

                $response = AddProductToCart($request->productData);
                return $response;
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

        return Response()->json(['status'=>true,"success" => "Product Delete Successfully"]);
    }
}
