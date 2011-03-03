<?php 
/* SVN FILE: $Id$ */
/* ItemsController Test cases generated on: 2009-02-07 20:02:54 : 1234061154*/
App::import('Controller', 'Items');

class TestItems extends ItemsController {
	var $autoRender = false;
}

class ItemsControllerTest extends CakeTestCase {
	var $Items = null;

	function setUp() {
		$this->Items = new TestItems();
		$this->Items->constructClasses();
	}

	function testItemsControllerInstance() {
		$this->assertTrue(is_a($this->Items, 'ItemsController'));
	}

	function tearDown() {
		unset($this->Items);
	}
}
?>