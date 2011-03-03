<?php 
/* SVN FILE: $Id$ */
/* Item Fixture generated on: 2009-02-07 20:02:36 : 1234060956*/

class ItemFixture extends CakeTestFixture {
	var $name = 'Item';
	var $table = 'items';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type'=>'string', 'null' => false, 'length' => 20),
			'category_id' => array('type'=>'integer', 'null' => false, 'default' => '0'),
			'name' => array('type'=>'string', 'null' => false, 'length' => 64),
			'description' => array('type'=>'text', 'null' => false),
			'indexes' => array('' => array('column' => NULL, 'unique' => 1))
			);
	var $records = array(array(
			'id'  => 1,
			'user_id'  => 'Lorem ipsum dolor ',
			'category_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
			));
}
?>