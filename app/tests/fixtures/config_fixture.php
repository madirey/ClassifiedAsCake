<?php 
/* SVN FILE: $Id$ */
/* Config Fixture generated on: 2009-02-07 21:02:56 : 1234063196*/

class ConfigFixture extends CakeTestFixture {
	var $name = 'Config';
	var $table = 'configs';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => false, 'length' => 64),
			'value' => array('type'=>'string', 'null' => false, 'length' => 128),
			'indexes' => array('' => array('column' => NULL, 'unique' => 1))
			);
	var $records = array(array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet'
			));
}
?>