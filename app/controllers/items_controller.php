<?php
class ItemsController extends AppController
{
	var $name = 'Items';

	var $helpers = array('Html', 'Form', 'Image');
	var $uses = array('Category', 'Item', 'Image');

	function index($searchId = null)
	{
		$this->paginate['Item'] = array(
			'limit' => 5,
			'order' => array(
				'Item.dist' => 'asc',
				'Item.created' => 'desc',
			),
			'recursive' => 1,
			'remoteUser' => $this->Session->read('User')
		);

		if(!empty($this->data['Item']['searchString']))
		{
			$this->set('items', $this->paginate('Item', array( 'or' => array(
				array('Item.name LIKE ' => '%'.$this->data['Item']['searchString'].'%'),
				array('Item.description LIKE ' => '%'.$this->data['Item']['searchString'].'%')))));
			$this->set('title', 'Search Results');
		}
		else if(isset($searchId))
		{
			$idArr = split('=', $searchId);
			$searchType = $idArr[0];
			$theId = $idArr[1];

			switch($searchType)
			{
				// search by category
				case 'c':
					$theCategory = $this->Category->findById($theId);

					if(!empty($theCategory))
					{
						$this->set('items', $this->paginate('Item', array('Category.id = ' => $theId)));
						$this->set('title', 'Listings in '.$theCategory['Category']['name']);
					}
					else
					{
						$this->Session->setFlash(__('Invalid ID specified.', true));
						$this->redirect(array('controller' => 'items', 'action' => 'index'));
						return;
					}
					break;

				// search by user
				case 'u':
					$theUser = $this->User->findById($theId);

					if(!empty($theUser))
					{
						$this->set('items', $this->paginate('Item', array('User.id = ' => $theId)));
						$this->set('title', 'Listings by '.$theUser['User']['username']);
					}
					else
					{
						$this->Session->setFlash(__('Invalid ID specified.', true));
						$this->redirect(array('controller' => 'items', 'action' => 'index'));
						return;
					}
					break;

				default:
					$this->Session->setFlash(__('Invalid ID specified.', true));
					$this->redirect(array('controller' => 'items', 'action' => 'index'));
					return;
			}
		}
		else
		{
			//pr($this->paginate('Item'));
			$this->set('items', $this->paginate('Item'));
			$this->set('title', 'Recent Listings');
		}
	}

	function respond($item_id = null)
	{
		if(!empty($this->data['Item']))
		{
			$item = $this->Item->find($this->data['Item']['item_id']);

			if(isset($item))
			{
				$me = $this->Session->read('User');

				if(isset($me))
				{
					$from = $me['email'];
					$replyTo = $me['email'];
				}
				else
				{
					$from = $this->data['Item']['email'];
					$replyTo = $this->data['Item']['email'];
				}

				$to = $item['User']['email'];
				$subject = $this->data['Item']['subject'];
				$body = $this->data['Item']['body'];

				$headers = 'MIME-Version: 1.0' . "\r\n" .
					'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
					'From: ' . $from . "\r\n" .
					'Reply-To: ' . $replyTo . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				if(mail($to, $subject, $body, $headers))
				{
					$this->Session->setFlash(__('Message sent.', true));
					$this->redirect(array('controller' => 'items', 'action' => 'index'));
					return;
				}
				else
				{
					$this->set('item', $item);
					$this->Session->setFlash(__('Message delivery failed.', true));
				}

			}
			else
			{
				$this->Session->setFlash(__('Invalid Item.', true));
				$this->redirect(array('action' => 'index'));
				return;
			}
		}
		else
		{
			if(!isset($item_id))
			{
				$this->Session->setFlash(__('Invalid Item.', true));
				$this->redirect(array('action' => 'index'));
				return;
			}
		
			$me = $this->Session->read('User');
			if(!isset($me))
			{
				$this->set('notLoggedIn', true);
			}
			else
			{
				$this->set('notLoggedIn', false);
			}

			$theItem = $this->Item->findById($item_id);
			if(empty($theItem))
			{
				$this->Session->setFlash(__('Invalid item.', true));
				$this->redirect(array('action' => 'index'));
				return;
			}

			$this->set('item', $this->Item->find($item_id));
		}
	}

	function results($page = 0, $limit = 10)
	{
		$this->layout = 'ajax';
		$itemArray = array();
		$count = $this->Item->findCount();
		$itemList = $this->Item->find('all', array(
			'limit' 	=> $limit,
			'page' 	=> $page,
			'order'	=> 'Item.created desc'
			)
		);
		//$itemArray = Set::extract($itemList, '//Item | //Image');
		/*
		$itemArray = array_combine(
			Set::extract($itemList, '{n}.Item'),
			Set::extract($itemList, '{n}.Image')
		);
		*/
		$itemArray = Set::extract($itemList, '{n}.Item');
		$imageArray = Set::extract($itemList, '{n}.Image');

		for($i = 0; $i < sizeof($itemArray); $i++)
		{
			if(!empty($imageArray[$i]))
			{
				$itemArray[$i]['image_path'] = $imageArray[$i][0]['image_path'];
			}
			else
			{
				$itemArray[$i]['image_path'] = null;
			}
		}

		//$itemArray = Set::extract($itemList, array('{n}.Item', '{n}.Image'));
		$this->set('total', $count);
		$this->set('page_size', $limit);
		$this->set('item_list', $itemArray);
	}

	function view($id = null)
	{
		if(!$id)
		{
			$this->Session->setFlash(__('Invalid Item.', true));
			$this->redirect(array('action' => 'index'));
			return;
		}
		$theItem = $this->Item->read(null, $id);

		if(empty($theItem))
		{
			$this->Session->setFlash(__('Invalid Item.', true));
			$this->redirect(array('action' => 'index'));
			return;
		}

		$this->set('item', $theItem);
		$this->set('title', $theItem['Item']['name']); 
	}

	function add()
	{
		$this->checkSession();

		if(!empty($this->data))
		{
			$this->Item->create();

			if($result = $this->Item->save($this->data))
			{
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->Session->write('itemId', $this->Item->id);
				$this->redirect(array('controller' => 'images', 'action'=>'add'));
			}
			else
			{
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}

		$user = $this->Session->read('User');
		$categories = $this->Item->Category->find('list');

		$this->set('categories', $categories);
		$this->set('user_id', $user['id']);
		$this->set('title', 'Create a New Listing');
	}

				//$this->data['Image']['item_id'] = $this->Item->id;
/*
				$this->__saveImage('image1');
				$this->__saveImage('image2');
				$this->__saveImage('image3');
				$this->Session->setFlash('Images uploaded successfully.');
				*/
				/*
				if($this->Item->Image->save($this->data))
				{
					$this->Session->setFlash(__('The Item has been saved', true));
					$this->redirect(array('action'=>'index'));
				}
				else
				{
					$this->Session->setFlash(__('The Item was saved, but an error occurred uploading the images', true));
				}
			}
			else
			{
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}

		$user = $this->Session->read('User');
		$categories = $this->Item->Category->find('list');

		$this->set('categories', $categories);
		$this->set('user_id', $user['id']);
	}
				*/

	function __saveImage($theImage)
	{
		if(!empty($this->data))
		{
			// set the upload destination folder
			$destination = realpath('../../app/webroot/img/uploads/') . '/';

			// grab the file
			$file = $this->data['Image'][$theImage];

			// upload the image using the upload component
			$result = $this->Upload->upload($file, $destination, null,
				array('type' => 'resizecrop', 'size' => array('400', '300'), 'output' => 'jpg'));

			if (!$result)
			{
				$this->data['Image']['image_path'] = $this->Upload->result;
			}
			else
			{
				// display error
				$errors = $this->Upload->errors;
   
				// piece together errors
				if(is_array($errors)){ $errors = implode("<br />",$errors); }
   
					$this->Session->setFlash($errors);
					$this->redirect('/images/upload');
					exit();
			}

			if ($this->Item->Image->save($this->data))
			{
				//$this->Session->setFlash('Image has been added.');
				//$this->redirect('/images/index');
				return true;
			}
			else
			{
				$this->Session->setFlash('Please correct errors below.');
				unlink($destination.$this->Upload->result);
				return false;
			}
		}
	}

	function edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Invalid Item', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data))
		{
			if ($this->Item->save($this->data))
			{
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->Item->read(null, $id);
		}
		$users = $this->Item->User->find('list');
		$categories = $this->Item->Category->find('list');
		$this->set(compact('users','categories'));
	}

	function delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid id for Item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Item->del($id))
		{
			$this->Session->setFlash(__('Item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function search()
	{
		if(!empty($this->data))
		{
			$this->set('items', $this->paginate('Item', array('Item.name LIKE' => '%'.$this->data['Item']['searchString'].'%')));
		}

		$this->set('title', 'Search for Listings');
	}

	function admin_index() {
		$this->Item->recursive = 0;
		$this->set('items', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Item.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('item', $this->Item->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Item->create();
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Item->User->find('list');
		$categories = $this->Item->Category->find('list');
		$this->set(compact('users', 'categories'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Item', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Item->read(null, $id);
		}
		$users = $this->Item->User->find('list');
		$categories = $this->Item->Category->find('list');
		$this->set(compact('users','categories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Item->del($id)) {
			$this->Session->setFlash(__('Item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
