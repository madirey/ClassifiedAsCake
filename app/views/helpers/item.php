<?php
class ItemHelper extends AppHelper
{
	var $helpers = array('Html');

	function showItems($items)
	{
		$markup = '<dl>';
		foreach($items as $item)
		{
			$markup .= '<dd>'.$this->Html->link($item['Item']['name'],
				array('controller' => 'items',
					'action' => 'view', $item['Item']['id'])).'</dd>';
		}

		$markup .= '</dl>';
		return $this->output($markup);
	}
}
?>
