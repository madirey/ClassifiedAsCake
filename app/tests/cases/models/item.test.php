<?php 
/* SVN FILE: $Id$ */
/* Item Test cases generated on: 2009-02-07 20:02:36 : 1234060956*/
App::import('Model', 'Item');

class ItemTestCase extends CakeTestCase {
	var $Item = null;
	var $fixtures = array('app.item', 'app.user', 'app.category');

	function startTest() {
		$this->Item =& ClassRegistry::init('Item');
	}

	function testItemInstance() {
		$this->assertTrue(is_a($this->Item, 'Item'));
	}

	function testItemFind() {
		$this->Item->recursive = -1;
		$results = $this->Item->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Item' => array(
			'id'  => 1,
			'user_id'  => 'Lorem ipsum dolor ',
			'category_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
			));
		$this->assertEqual($results, $expected);
	}
}
?>