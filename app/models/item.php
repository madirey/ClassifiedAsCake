<?php
class Item extends AppModel
{
	var $name = 'Item';

	var $actsAs = array('Containable');

	var $validate = array(
		'user_id' => array('notempty'),
		'category_id' => array('numeric'),
		'name' => array('notempty'),
		'created_date' => array('numeric')
	);

	var $belongsTo = array('User', 'Category');
	var $hasMany = array('Image');

	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array())
	{
		$orderBy = 'order by ';
		foreach($order as $col => $dir)
		{
			if($col === 'Item.dist')
			{
				if(isset($extra['remoteUser']))
				{
					$orderBy .= ('Distance.distance ' . $dir . ', ');
				}
				else
				{
					continue;
				}
			}
			else
			{
				$orderBy .= ($col . ' ' . $dir . ', ');
			}
		}
		$orderBy = substr($orderBy, 0, -2);

		$firstRow = (max(1, $page) - 1)  * $limit;
		$limitStr = 'limit ' . $firstRow . ',' . $limit; 

		// Only supports 1 condition for now
		$conditionsStr = '';
		if(!empty($conditions))
		{
			//$keys = array_keys($conditions);
			//$values = array_values($conditions);
			//$conditionsStr = 'where '. $keys[0] . ' = ' . $values[0];
			$conditionsStr = 'where ' . parseConditions($conditions);
		}

		if(isset($extra['remoteUser']))
		{
			$distanceCol = ', Distance.distance ';
			$distanceStr = 
				"left join distances as Distance on (".
				"(Distance.location1_id = ". $extra['remoteUser']['location_id'] . " and Distance.location2_id = User.location_id) or ".
				"(Distance.location2_id = ". $extra['remoteUser']['location_id'] . " and Distance.location1_id = User.location_id)) ";
		}
		else
		{
			$distanceCol = '';
			$distanceStr = '';
		}

		$sql = "select Item.id, Item.user_id, Item.category_id, Item.name, Item.description, Item.price, ".
			"Item.created, User.id, User.username, User.location_id, Category.id, Category.name, Image.image_path ".
			$distanceCol .
			"from items as Item ".
			"left join users as User on (Item.user_id = User.id) ".
			"left join categories as Category on (Item.category_id = Category.id) ".
			"left join images as Image on (Image.item_id = Item.id) ".
			$distanceStr .
			$conditionsStr . ' '.
			$orderBy.' '.
			$limitStr;

		$results = $this->query($sql);

		return $results;
	}

	function paginateCount($conditions = null, $recursive = 0, $extra = array())
	{
		/*
		$sql = "select Item.id, Item.user_id, Item.category_id, Item.name, Item.description, Item.price, ".
			"Item.created, User.id, User.username, User.location_id, Category.id, Category.name ".
			"from items as Item ".
			"left join users as User on (Item.user_id = User.id) ".
			"left join categories as Category on (Item.category_id = Category.id) ".
			"where 1 = 1 order by Item.created desc limit 10";
		*/

		$count = $this->find('count', array('conditions' => $conditions));
		return $count;
	}
}
?>
