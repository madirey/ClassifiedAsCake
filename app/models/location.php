<?php
class Location extends AppModel
{
	var $name = 'Location';

	var $hasAndBelongsToMany = array(
		'DistanceSrc' => array(
			'className' => 'Location',
			'joinTable' => 'distances',
			'foreignKey' => 'location1_id',
			'associationForeignKey' => 'location2_id',
			'unique' => true
		),
		'DistanceDest' => array(
			'className' => 'Location',
			'joinTable' => 'distances',
			'foreignKey' => 'location2_id',
			'associationForeignKey' => 'location1_id',
			'unique' => true
		)
	);

	var $hasMany = array('User');

	function calculateDistance($loc1, $loc2)
	{
		$lat1 = degToRad($loc1['latitude']);
		$lat2 = degToRad($loc2['latitude']);
		$long1 = degToRad($loc1['longitude']);
		$long2 = degToRad($loc2['longitude']);

		$dlon = $long2 - $long1;
		$dlat = $lat2 - $lat1;
		$a = pow(sin($dlat / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($dlon / 2), 2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$d = 3956 * $c;
		/*
		$distance = acos(
			sin($loc1['latitude'])*sin($loc2['latitude']) + cos($loc1['latitude']) * cos($loc2['latitude']) *
			cos($loc2['longitude'] - $loc1['longitude'])) * 3959;
		return $distance;
		*/
		return $d;
	}

	function getCoords($zip_code)
	{
		$request = 'http://local.yahooapis.com/MapsService/V1/geocode?'
			.'appid=Nitenl3V34GC0wFgTbi1GITNqMaOFsiC4Yu0KtrsUJxhA7Pw1q9QbBegJPv6mo47clYYFg--'
			.'&zip='.urlencode($zip_code);

		$xml = file_get_contents($request);

		// Get HTTP status code
		list($version, $status, $msg) = explode(' ', $http_response_header[0], 3);

		switch($status)
		{
			case 200:
				// Success
				break;
			case 503:
			case 400:
			default:
				return null;	
		}

		// Get the latitude and longitude from XML
		if(!preg_match('/<Latitude>(.*)?<\/Latitude>/', $xml, $lat_match))
		{
			return null;
		}

		if(!preg_match('/<Longitude>(.*)?<\/Longitude>/', $xml, $long_match))
		{
			return null;
		}

		$latitude = $lat_match[1];
		$longitude = $long_match[1];

		return array(doubleval($latitude), doubleval($longitude));
	}
}
?>
