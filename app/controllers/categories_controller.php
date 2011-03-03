<?php
class CategoriesController extends AppController
{
	var $name = 'Categories';

	var $helpers = array('Form', 'Html', 'Image', 'Item');
	var $uses = array('Item');

	var $paginate = array(
		'limit' => 10,
		'order' => array(
			'Category.name' => 'asc'
		)
	);

	function index()
	{
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

	function view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid Category.', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('category', $this->Category->read(null, $id));
		$this->set('items',
			$this->Item->find('all', array('conditions' => array('category_id' => $id))));
	}


	/**
	 * Admin Functionality
	 */
	function admin_index()
	{
		$this->set('categories', $this->paginate());
	}

	function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid Category.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	function admin_add()
	{
		if (!empty($this->data))
		{
			$this->Category->create();
			if ($this->Category->save($this->data))
			{
				$this->Session->setFlash(__('The Category has been saved', true));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Category could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Invalid Category', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data))
		{
			if ($this->Category->save($this->data))
			{
				$this->Session->setFlash(__('The Category has been saved', true));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Category could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->Category->read(null, $id);
		}
	}

	function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid id for Category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->del($id))
		{
			$this->Session->setFlash(__('Category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
