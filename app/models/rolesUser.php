<?php
class RolesUser extends AppModel
{
	var $name = 'RolesUser';
	var $belongsTo = array('Role', 'User');
}
?>
