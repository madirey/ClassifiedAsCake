<?php
class Config extends AppModel
{
	var $name = 'Config';
	var $validate = array(
		'name' => array('notempty'),
		'value' => array('notempty')
	);

	function getConfig($name)
	{
		return $this->find('first',
			array('conditions' => array('Config.name' => $name)));
	}

	function setConfig($name, $value)
	{

	}
}
?>
