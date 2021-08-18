<?php
	function asset_img($imgpath,$folder_name)
	{
		/*$path_chaek = public_path().'/backend_asset/user_img/'.$imgpath;*/

		$img_default = asset('/backend_asset/images/default.png');
		if( !is_null($imgpath) && $imgpath != '' && file_exists(public_path('/backend_asset/'.$folder_name.'/'.$imgpath)) )
		{
			$img_default = asset('/backend_asset/'.$folder_name.'/'.$imgpath);
		}	
		return $img_default;
	}

	//function for get setting values from setting name
	function SettingValue($SettingArray,$SettingName)
	{	

		$SettingIndex = array_search($SettingName,array_column($SettingArray,'setting_name'));
		if($SettingIndex !== false)
		{
			return	$SettingArray[$SettingIndex]['setting_value'];
		}
	}



	 function coupons() 
     {
                if($cart_detail->coupon_code)
                {
                    foreach($cart_detail->coupon_code as $key => $value){
                        
                        if($request->coupon_code == $value)
                        {
                            return Response()->json("This Coupone Alredy Apply");
                        }
                        $coupon_detail = Coupone::where('coupon_code',$value)->first();
                        
                        if($coupon_detail->coupon_type == "product"){
                            if($key == $coupon_detail->coupon_type_value){
                                //dd($coupon_detail->coupon_type_value);
                                if($coupon_detail->discount_type == "fixed"){
                                    $cart_detail->discount -= $coupon_detail->coupon_discount;
                                  // dd($cart_detail->discount);
                                }elseif($coupon_detail->discount_type == "percentage"){
                                    $cart_item = CartItem::where('product_id',$coupon_detail->coupon_type_value)->first();

                                    if(!is_null($cart_item)){
                                    $total_amt = $cart_item->price*$cart_item->quantity;

                                    $discount = $total_amt/100*$coupon_detail->coupon_discount;

                                    $cart_detail->discount -= $discount;

                                    }
                                }
                            }
                        
                        }
                        if($coupon_detail->coupon_type == "category"){
                            
                            $product = Product::where('category_id',$coupon_detail->coupon_type_value)->get();
                            //dd($product);
                            foreach($product as $products){
                                $discount_product = CartItem::where('product_id',$products->id)->first();
                               // dd($discount_product);
                                if(!is_null($discount_product)){
                                    $coupon_detail = Coupone::where('coupon_code',$value)->first();
                                    // dd($coupon_detail);
                                    if($coupon_detail->discount_type == "fixed"){
                                        $cart_detail->discount -= $coupon_detail->coupon_discount;
                                        //dd($cart_detail->discount);
                                    }else{
                                        $cart_item = CartItem::where('product_id',$products->id)->first();
                                        $total_amt = $cart_item->price*$cart_item->quantity;
                                        $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                        $cart_detail->discount -= $discount;
                                        
                                    }   
                                }
                            }
                              
                        }
                    }
                    $cart_detail->save(); 
                }
                 
                
                if($coupon->coupon_type == "product")
                {
                    $product = Product::find($coupon->coupon_type_value);
                    //dd($product);   
                    $price = isset($product->special_price)?$product->special_price:$product->current_price;
                    // dd($price);
                    if($coupon->discount_type == "fixed"){
                        //dd($cart_detail);
                        $cart_detail->discount += $coupon->coupon_discount;
                    }elseif($coupon->discount_type == "percentage"){
                        $discount = $price/100*$coupon->coupon_discount;
                        $cart_detail->discount += $discount;
                    }
                    if(is_null($cart_detail->coupon_code))
                    {
                        $cart_detail->coupon_code =[
                           $product->id => $request->coupon_code
                        ];
                    }else{
                        $new_code = array_replace($cart_detail->coupon_code,[$product->id => $request->coupon_code]);
                        $cart_detail->coupon_code = $new_code;
                    }
                   // dd($cart_detail->coupon_code);
                    $cart_detail->save();
                }elseif($coupon->coupon_type == "category"){
                    $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                    
                    foreach($product as $value){
                        $discount_product = CartItem::where('product_id',$value->id)->first();
                        if(!is_null($discount_product)){
                        $cart_product = Cart::where('id',$discount_product->cart_id)->first();
                          
                            if($coupon->discount_type == "fixed"){
                                $cart_product->discount += $coupon->coupon_discount;
                                if(is_null($cart_detail->coupon_code))
                                {
                                    $cart_product->coupon_code =[
                                       $value->id => $request->coupon_code
                                    ];
                                }else{
                                    $new_code = array_replace($cart_detail->coupon_code,[$value->id => $request->coupon_code]);
                                    $cart_product->coupon_code = $new_code;
                                }
                               $cart_product->save();
                            }elseif($coupon->discount_type == "percentage"){
                                $discount = $discount_product->price/100*$coupon->coupon_discount;
                                $cart_product->discount += $discount;
                                
                                if(is_null($cart_detail->coupon_code))
                                {
                                    $cart_product->coupon_code =[
                                       $value->id => $request->coupon_code
                                    ];
                                }else{
                                    $new_code = array_replace($cart_detail->coupon_code,[$value->id => $request->coupon_code]);
                                    $cart_product->coupon_code = $new_code;
                                }
                                $cart_product->save();
                            }
                        }
                        
                    }
                    
                    
                }
               
            }


	// function sk()
	// {
	// 	return 'aa';	
	// }
?>