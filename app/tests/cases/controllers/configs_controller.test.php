<?php 
/* SVN FILE: $Id$ */
/* ConfigsController Test cases generated on: 2009-02-07 21:02:18 : 1234063218*/
App::import('Controller', 'Configs');

class TestConfigs extends ConfigsController {
	var $autoRender = false;
}

class ConfigsControllerTest extends CakeTestCase {
	var $Configs = null;

	function setUp() {
		$this->Configs = new TestConfigs();
		$this->Configs->constructClasses();
	}

	function testConfigsControllerInstance() {
		$this->assertTrue(is_a($this->Configs, 'ConfigsController'));
	}

	function tearDown() {
		unset($this->Configs);
	}
}
?>