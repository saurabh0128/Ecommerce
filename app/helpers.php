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

	function sk()
	{
		return 'aa';	
	}
?>