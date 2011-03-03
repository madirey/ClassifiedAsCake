<?php
/* SVN FILE: $Id: bootstrap.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * Long description for file
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
//EOF

function parseConditions($node)
{
	$keys = array_keys($node);

	if(in_array('or', $keys))
	{
		return parseConditions($node['or'][0]) . ' or ' . parseConditions($node['or'][1]);
	}
	else if(in_array('and', $keys))
	{
		return parseConditions($node['and'][0]) . ' and ' . parseConditions($node['and'][1]);
	}
	else
	{
		$lhs = $keys[0];
		$rhs = $node[$lhs];

		if(!is_numeric($rhs))
		{
			$rhs = "'" . $rhs . "'";
		}
		return $lhs . $rhs;
	}
}

function distanceSortAsc($a, $b)
{
	if($a['Distance']['distance'] == $b['Distance']['distance'])
	{
		return 0;
	}

	return ($a['Distance']['distance'] > $b['Distance']['distance']) ? 1 : -1;
}

function distanceSortDesc($a, $b)
{
	if($a['Distance']['distance'] == $b['Distance']['distance'])
	{
		return 0;
	}

	return ($a['Distance']['distance'] < $b['Distance']['distance']) ? 1 : -1;
}

function degToRad($deg)
{
	return $deg * (pi() / 180.0);
}

?>
