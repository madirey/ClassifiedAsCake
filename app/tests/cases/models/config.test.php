<?php 
/* SVN FILE: $Id$ */
/* Config Test cases generated on: 2009-02-07 21:02:56 : 1234063196*/
App::import('Model', 'Config');

class ConfigTestCase extends CakeTestCase {
	var $Config = null;
	var $fixtures = array('app.config');

	function startTest() {
		$this->Config =& ClassRegistry::init('Config');
	}

	function testConfigInstance() {
		$this->assertTrue(is_a($this->Config, 'Config'));
	}

	function testConfigFind() {
		$this->Config->recursive = -1;
		$results = $this->Config->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Config' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet'
			));
		$this->assertEqual($results, $expected);
	}
}
?>