<?php
/**
 * Special thanks to exuber.net for recaptcha component and integration.
 */
class AppController extends Controller
{
	var $helpers = array('Admin', 'CategoryMenu', 'Html', 'Javascript', 'Session');
	public $uses = array('Category', 'Config', 'Image', 'Item', 'User');

	function beforeFilter()
	{
		if(isset($this->params['admin']))
		{
			$this->checkAdmin();
		}
	}

	function beforeRender()
	{
		$categoryList = $this->Category->find('all');
		$configArray = $this->Config->find('list', array('fields' =>
			array('Config.name', 'Config.value')));
		$frontPageDisplayType = $this->Config->getConfig('frontPageDisplayType');
		$imageRoot = $this->Config->getConfig('imageRoot');
		$showAdminLink = $this->Config->getConfig('showAdminLink');
		$siteTitle = $this->Config->getConfig('siteTitle');
		$this->set('categoryList', $categoryList);
		$this->set('configArray', $configArray);
		$this->set('frontPageDisplayType', $frontPageDisplayType);
		$this->set('imageRoot', $imageRoot);
		$this->set('showAdminLink', $showAdminLink);
		$this->set('siteTitle', $siteTitle);
	}

	function checkAdmin()
	{
		$this->checkSession();
		if(!$this->User->isAdmin($this->Session->read('User')))
		{
			$this->Session->setFlash(__('You do not have administrative rights.', true));
			$this->redirect('/', null, true);
		}
	}

	function checkSession()
	{
		if(!$this->Session->check('User'))
		{
			$this->Session->write('lastPageVisited', $this->params['url']['url']);
			$this->redirect('/users/login', null, true);
			exit();
		}
		else
		{
			$user = $this->Session->read('User');
			$this->set('User', $user);
		}
	}
}
?>
