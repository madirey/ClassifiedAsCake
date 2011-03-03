<?php
class ImagesController extends AppController
{
	var $name = 'Images';

	var $components = array('Upload');
	var $helpers = array('Html', 'Form');
	var $uses = array('Image', 'Item');

	var $paginate = array(
		'limit' => 5,
		'order' => array('Image.id' => 'asc')
	);

	function add()
	{
		if(!empty($this->data))
		{
			$this->data['Image']['item_id'] = $this->Session->read('itemId');

			if(!empty($this->data['Image']['item_id']))
			{
				$this->__saveImage();
				/*
				if($result = $this->Image->save($this->data))
				{
					$this->Session->setFlash(__('The Image has been uploaded', true));
					$this->redirect(array('controller' => 'items', 'action'=>'index'));
				}
				else
				{
					$this->Session->setFlash(__('The Image could not be saved. Please, try again.', true));
				}
				*/
			}
			else
			{
				$this->Session->setFlash(__('Error: No item ID provided', true));
				$this->redirect(array('controller' => 'items', 'action' => 'index'));
			}
		}
	}

	function __saveImage()
	{
		if(!empty($this->data['Image']['data']))
		{
			// set the upload destination folder
			$destination = realpath('../../app/webroot/img/uploads/') . '/';

			// grab the files
			$file = $this->data['Image']['data'];

			// upload the image using the upload component
			$result = $this->Upload->upload($file, $destination, null,
				array('type' => 'resizecrop', 'size' => array('400', '300'), 'output' => 'jpg'));

			if (!$result)
			{
				//$this->data['Image']['image_path'] = $fileName;
				//$this->data['Image']['image_data'] = null;
				$this->data['Image']['image_path'] = $this->Upload->result;
			}
			else
			{
				// display error
				$errors = $this->Upload->errors;

				// unlink
				unlink($destination. $this->Upload->result);
   
				// piece together errors
				if(is_array($errors)){ $errors = implode("<br />",$errors); }
   
					$this->Session->setFlash($errors);
					$this->redirect('/items');
					exit();
			}

			unset($this->data['Image']['data']);

			if ($this->Image->save($this->data))
			{
				$this->Session->setFlash('Image has been added.');
				$this->redirect('/items/view/'.$this->Session->read('itemId'));
			}
			else
			{
				$this->Session->setFlash('Please correct errors below.');
				unlink($destination.$this->Upload->result);
			}
		}
	}

}
?>
