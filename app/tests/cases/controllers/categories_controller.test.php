<?php 
/* SVN FILE: $Id$ */
/* CategoriesController Test cases generated on: 2009-02-07 15:02:14 : 1234042814*/
App::import('Controller', 'Categories');

class TestCategories extends CategoriesController {
	var $autoRender = false;
}

class CategoriesControllerTest extends CakeTestCase {
	var $Categories = null;

	function setUp() {
		$this->Categories = new TestCategories();
		$this->Categories->constructClasses();
	}

	function testCategoriesControllerInstance() {
		$this->assertTrue(is_a($this->Categories, 'CategoriesController'));
	}

	function tearDown() {
		unset($this->Categories);
	}
}
?>