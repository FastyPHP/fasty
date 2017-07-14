<?php
function GetIp() : string {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}

function GetBrowser() : array {
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";
	if(preg_match('/linux/i', $u_agent)){
		$platform = 'linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$platform = 'mac';
	}
	elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'windows';
	}
	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
	{
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	}
	elseif(preg_match('/Firefox/i',$u_agent))
	{
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	}
	elseif(preg_match('/Chrome/i',$u_agent))
	{
		$bname = 'Google Chrome';
		$ub = "Chrome";
	}
	elseif(preg_match('/Safari/i',$u_agent))
	{
		$bname = 'Safari';
		$ub = "Safari";
	}
	elseif(preg_match('/Opera/i',$u_agent))
	{
		$bname = 'Opera';
		$ub = "Opera";
	}
	elseif(preg_match('/Netscape/i',$u_agent))
	{
		$bname = 'Netscape';
		$ub = "Netscape";
	}

	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
	')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if(!preg_match_all($pattern, $u_agent, $matches)) {
	}
	$i = count($matches['browser']);
	if ($i != 1) {
		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			$version= $matches['version'][0];
		}
		else {
			$version= $matches['version'][1];
		}
	}
	else {
		$version= $matches['version'][0];
	}

	if ($version==null || $version=="") {$version="?";}
	return [
		'userAgent' => $u_agent,
		'name'      => $bname,
		'version'   => $version,
		'platform'  => $platform,
		'pattern'    => $pattern
	];
}

function GetOS() : string {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$os_platform    =   "Unknown OS Platform";
	$os_array       =   [
		'/windows nt 10.0/i'    =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iOS - iPhone',
		'/ipod/i'               =>  'iOS - iPod',
		'/ipad/i'               =>  'iOS - iPad',
		'/android/i'            =>  'Android',
		'/windows phone 10.0/i' =>  'Windows Phone 10',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
	];

	foreach($os_array AS $regex => $value)
		if(preg_match($regex, $user_agent))
			$os_platform = $value;

	return $os_platform;
}

function RandString(int $length = 10, bool $special = true) : string {

	if(!$special)
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	else
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=()#%$&{}';

	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++){
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function getURL() : string {
	if(!empty($_SERVER['HTTPS'])) $protocol = 'https://';
	else $protocol = 'http://';
	return str_replace("\\", "/", $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
}

function convertBytes(int $size) : string {

	$unit = ['b','KB','MB','GB','TB','PB'];

	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function orderArray(array $array, string $key) : array {

	$size = count($array);

	for($i = 0; $i < $size; $i++)   {
		for($j = $i + 1; $j < $size; $j++)   {
			if($array[$i][$key] > $array[$j][$key]) {
				$c				=   $array[$i];
				$array[$i]  	=   $array[$j];
				$array[$j]		=   $c;
			}
		}
	}

	return $array;
}

function lotto(int $pool, int $num) : bool {

	return (mt_rand(1, $pool) > $num);
}
?>
