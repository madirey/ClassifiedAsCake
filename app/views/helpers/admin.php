<?php
class AdminHelper extends AppHelper
{
	var $helpers = array('Html', 'Session');

	function showFrontPage($frontPageDisplayType)
	{
		$markup = '<dl>';
		if($frontPageDisplayType['Config']['value'] === 'featured')
		{
			$markup .= '<li>Featured Listings</li>';	
		}
		else if($frontPageDisplayType['Config']['value'] === 'latest')
		{
			$markup .= '<li>Most Recent Listings</li>';
		}
		$markup .= '</dl>';

		return $this->output($markup);
	}

	function showLoginLogout()
	{
		if($this->Session->check('User'))
		{
			return $this->output(
				$this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => 0)));
		}
		else
		{
			return $this->output(
				$this->Html->link('Login', array('controller' => 'users', 'action' => 'login', 'admin' => 0)));
		}
	}

	function showRegister()
	{
		if(!$this->Session->check('User'))
		{
			return $this->output(
				$this->Html->link('Register', array('controller' => 'users', 'action' => 'register', 'admin' => 0)));
		}
	}

	function showAdminLink($showAdminLink)
	{
		if($showAdminLink['Config']['value'] === 'true')
		{	
			return $this->output('<li>'.$this->Html->link('Admin Pages',
				array('controller' => 'users', 'action' => 'admin')).'</li>');
		}
	}
}
?>
