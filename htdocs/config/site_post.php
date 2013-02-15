<?php

if(!isset($_SESSION["city"]))
	$_SESSION["city"] = getPreferedCity();

function getPreferedCity()
{
	$db = Loader::db( 'localhost', 'geo', 'geo123', 'maxmind', true);
	$long_ip = ip2long(getCurrentIp());

	$l =<<<SQL
		SELECT * 
		FROM blocks b 
		JOIN location l ON (l.locId = b.locId) 
		WHERE $long_ip BETWEEN startIpNum and endIpNum
SQL;

	$geo = $db->GetRow($l);

	//reset db connection, this is silly, comon guys
	$db = Loader::db(null, null, null, null, true);

	$p =<<<SQL
		SELECT *,
		(abs(abs({$geo['latitude']}) - abs(c.latitude)) + abs(abs({$geo['longitude']}) - abs(c.longitude))) as distance,
		replace(name, ' ', '-') as url_string
		FROM preferCity c
		ORDER BY distance ASC
SQL;

	$city = $db->GetRow($p); 
	return $city;
}

function getCurrentIp()
{    
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {    
        $ip = current(explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']));
    }        
    else 
    {    
        $ip = $_SERVER['REMOTE_ADDR'];
    }        

    return $ip;
}        
