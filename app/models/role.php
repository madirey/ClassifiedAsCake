<?php
class Role extends AppModel {
	var $name = 'Role';
	var $hasAndBelongsToMany = array('User');
}
?>
