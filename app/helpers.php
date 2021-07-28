<?php
	function asset_img($imgpath,$folder_name)
	{
		/*$path_chaek = public_path().'/backend_asset/user_img/'.$imgpath;*/

		$img_default = asset('/backend_asset/images/default.png');
		if( !is_null($imgpath) && $imgpath != '' && file_exists(public_path('/backend_asset/user_img/'.$imgpath)) )
		{
			$img_default = asset('/backend_asset/'.$folder_name.'/'.$imgpath);
		}	
		return $img_default;
	}
?>