<?php
class User extends AppModel
{
	var $name = 'User';

	var $belongsTo = array('Location');
	var $hasMany = array('Item');
	var $hasAndBelongsToMany = array('Role');

	var $validate = array(
		'username' => array(
			'exists' => array(
				'rule' => array('checkUnique', 'username'),
				'message' => 'The username you entered has been taken.'
			)
		),
		'email' => array(
			'rule' => 'email',
			'message' => 'Please supply a valid email address.'
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', '6'),
				'message' => 'Minimum 6 characters long'
			)
		),
		'zip_code' => array(
			'rule' => 'postal',
			'message' => 'Please enter a valid zip code.'
		)
	);

	function validateLogin($data)
	{
		$user = $this->find('first', array(
				'conditions' => array('username' => $data['username'], 'password' => md5($data['password'])),
				'fields' => array('id', 'username', 'email', 'location_id'),
				'recursive' => 0
			)
		);

		if(empty($user) == false)
		{
			return $user['User'];
		}

		return false;
	}

	function checkUnique($data, $fieldName)
	{
		$valid = false;

		if(isset($fieldName) && $this->hasField($fieldName))
		{
			$valid = $this->isUnique(array($fieldName => $data));
		}
		
		return $valid;
	}

	function isAdmin($user)
	{
		if(in_array(1, $user['userRoles']))
		{
			return true;
		}

		return false;
	}
}
?>
