<?php
class CategoryMenuHelper extends AppHelper
{
	var $helpers = array('Html');

	function display($categories)
	{
		$markup = '<ul>';
		foreach($categories as $category)
		{
			$markup .= '<li>'.
				$this->Html->link($category['Category']['name'],
					array('controller' => 'items', 'action' => 'index',
						'c='.$category['Category']['id']),
					array())
				.'</li>';
		}
		$markup .= '</ul>';

		return $this->output($markup);
	}
}
?>
