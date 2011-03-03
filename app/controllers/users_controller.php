<?php
class UsersController extends AppController
{
	var $name = 'Users';

	var $components = array('Recaptcha');
	var $helpers = array('Html', 'Form');
	var $uses = array('Distance', 'Location', 'RolesUser');

	/*
	function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	*/

	function admin()
	{
		$this->checkAdmin();
		$this->set('title', 'Admin Pages');
	}

	function register()
	{
		if(!empty($this->data))
		{
			if($this->data['User']['retypePassword'] == $this->data['User']['password'])
			{
				if($this->Recaptcha->verify())
				{
					$this->add();

					$this->Session->setFlash('Thank you for registering.');
					$this->redirect('login', null, true);
					exit();
				}
				else
				{
					$this->Session->setFlash('Captcha verification failed.');
				}
			}
			else
			{
				$this->Session->setFlash('Passwords do not match.');
			}
		}

		$this->set('title', 'New User Registration');
	}

	function recaptcha()
	{
		$this->Recaptcha->render();
	}

	function login()
	{
		if(!empty($this->data))
		{
			if(($user = $this->User->validateLogin($this->data['User'])) == true)
			{
				// Look up the user's roles
				$userRoles = $this->RolesUser->find('list', array('conditions' => array('RolesUser.user_id' => $user['id']),
					'fields' => 'role_id'));
				$user['userRoles'] = $userRoles;

				// Write to session
				$this->Session->write('User', $user);

				$this->Session->setFlash('You\'ve successfully logged in.');
				$url = $this->Session->read('lastPageVisited');

				if($url !== NULL)
				{
					$this->redirect('/' . $url, null, true);
				}
				else
				{
					$this->redirect('/items', null, true);
				}
			}
			else
			{
				$this->Session->setFlash('Sorry, the information you\'ve entered is incorect.');
				//exit();
			}
		}

		$this->set('title', 'User Login');
	}

	function logout()
	{
		$this->Session->destroy('user');
		$this->Session->setFlash('You\'ve successfully logged out.');
		$this->redirect('login', null, true);
	}

	function __validateLoginStatus()
	{
		if($this->action != 'login' && $this->action != 'logout')
		{
			$this->redirect('login', null, true);
			$this->Session->setFlash('The URL you\'ve followed requires you to login.');
		}
	}

	function view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'), null, true);
		}

		$theUser = $this->User->read(null, $id);
		$this->set('user', $theUser); 
		$this->set('title', $theUser['User']['username'].'\'s Profile'); 
	}

	function add()
	{
		if (!empty($this->data))
		{
			// Pre-process data
			$this->data['User']['password'] = md5($this->data['User']['password']);
			$this->data['Role']['id'] = 5;

			// Create / lookup the location
			$myLocation = $this->Location->findByZipCode($this->data['Location']['zip_code']);

			if(empty($myLocation))
			{
				if($coords = $this->Location->getCoords($this->data['Location']['zip_code']))
				{
					$this->data['Location']['latitude'] = $coords[0];
					$this->data['Location']['longitude'] = $coords[1];
					$this->Location->create();

					$locationArr = array();
					$locationArr['Location'] = $this->data['Location'];

					if($this->Location->save($locationArr))
					{
						$location_id = $this->Location->id;
					}
					else
					{
						$this->Session->setFlash(__('Error saving location information.', true));
						return;
					}

					// Calculate distances
					$locations = $this->Location->find('all');
					foreach($locations as $location)
					{
						if($location['Location']['id'] !== $location_id)
						{
							$distance = $this->Location->calculateDistance($this->data['Location'], $location['Location']);
							$theDistance = array('Distance' => array(
								'location1_id' => $location_id,
								'location2_id' => $location['Location']['id'],
								'distance' => $distance
								)
							);

							$this->Distance->create();
							if($this->Distance->save($theDistance))
							{

							}
							else
							{
								$this->Session->setFlash(__('Error saving distance data.', true));
								return;
							}
						}
					}
				}
				else
				{
					$this->Session->setFlash(__('Error retrieving location information.', true));
					return;
				}
			}
			else
			{
				$location_id = $myLocation['Location']['id'];
			}

			// Create the user
			unset($this->data['Location']);
			unset($this->data['User']['retypePassword']);
			$this->data['User']['location_id'] = $location_id;

			$this->User->create();
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'login'), null, true);
			}
			else
			{
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
		if (!empty($this->data))
		{
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'), null, true);
			}
			else
			{
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
		if ($this->User->del($id))
		{
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
	}

	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'), null, true);
		}
	}

}
?>
