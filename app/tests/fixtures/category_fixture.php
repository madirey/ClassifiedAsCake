<?php 
/* SVN FILE: $Id$ */
/* Category Fixture generated on: 2009-02-07 15:02:46 : 1234042906*/

class CategoryFixture extends CakeTestFixture {
	var $name = 'Category';
	var $table = 'categories';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => false, 'length' => 128),
			'indexes' => array('' => array('column' => NULL, 'unique' => 1))
			);
	var $records = array(array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet'
			));
}
?>