<?php
/* SVN FILE: $Id: pages_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';
/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Form', 'Html');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$pageName = $path[$count - 1];

			switch($pageName)
			{
				case 'terms':
					$title = 'Terms of Use';
					break;

				case 'faq':
					$title = 'Frequently Asked Questions';
					break;

				case 'privacy':
					$title = 'Privacy Policy';
					break;

				case 'about':
					$title = 'About MonetizeMyCar.com';
					break;

				case 'contact':
					if(isset($this->data))
					{
						$this->contact();
					}
					else
					{
						$title = 'Contact MonetizeMyCar.com';
						$this->set('me', $this->Session->read('User'));
					}
					break;

				case 'donate':
					$title = 'Make a Donation';
					break;

				default:
					$title = Inflector::humanize($path[$count - 1]);
			}
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}

	function contact()
	{
		if(isset($this->data['Page']['email']))
		{
			$email = $this->data['Page']['email'];
			$from = $email;
			$replyTo = $email;
		}
		else
		{
			$me = $this->Session->read('User');

			if(isset($me))
			{
				$from = $me['email'];
				$replyTo = $me['email'];
			}
			else
			{
				$this->Session->setFlash(__('Not logged in.', true));
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
				return;
			}
		}

		// TODO: validation
		$subject = $this->data['Page']['subject'];
		$body = $this->data['Page']['body'];

		$to = 'support@monetizemycar.com';
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
			$this->Session->setFlash(__('Message delivery failed.', true));
		}
	}
}

?>
