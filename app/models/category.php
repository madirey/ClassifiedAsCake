<?php
class Category extends AppModel {

	var $name = 'Category';
	var $hasMany = 'Item';
	var $validate = array(
	//	'id' => array('maxLength = 128'),
		'name' => array('maxlength = 128')
	);

	/*
	var $hasMany = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'order' => '',
			'limit' => '',
			'dependent' => true
		)
	);
	*/

}
?>
