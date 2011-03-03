<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2009-02-07 17:02:35 : 1234050815*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'email' => array('type'=>'string', 'null' => false, 'length' => 128, 'key' => 'unique'),
			'password' => array('type'=>'string', 'null' => false, 'length' => 128),
			'indexes' => array('' => array('column' => array('', ''), 'unique' => 1))
			);
	var $records = array(array(
			'id'  => 1,
			'email'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet'
			));
}
?>