<?php
class ImageHelper extends AppHelper
{
	var $helpers = array('Html');

	function showImage($imgArray, $item_id,
		$dimensions = array('width' => 200, 'height' => 150))
	{
		if(!empty($imgArray['image_path']) || !empty($imgArray[0]))
		{
			if(isset($imgArray[0]))
			{
				$path = 'uploads/'.$imgArray[0]['image_path'];
			}
			else
			{
				$path = 'uploads/'.$imgArray['image_path'];
			}
		}
		else
		{
			$path = 'no_image.png';
		}

		return $this->output('<img src="/img/'.$path.'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" alt="tbd" />');
	}
}
?>
