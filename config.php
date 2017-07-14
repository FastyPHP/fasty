<?php
return [
	'site_name'			=>	'Fasty application',
	'site_uri'			=>	'http://localhost',
	'timezone'			=>	'Europe/Sarajevo',
	'language'			=>	'English',
	'sslonly'			=>	false,
	'underdev'			=>	true,
	'displayConsole'	=>	true,
	'maintance'			=>	false,
	'maintanceMsg'		=>	'Be back soon!',
	'tempPath'			=>	'Templates/Views',
	'tempComp'			=>	'Templates/Compile',
	'tempCach'			=>	'Templates/Cache',
	'tempCachTime'		=>	0,
	'langPath'			=>	'../Languages',
	'logPath'			=>	'../Logs',
	'crypto_key'		=>	'a,/L523[}(0?lNzAd@y>a._b', # Change this to your own key
	'crypto_iv'			=>	'-wĄ%H4Â÷·c',
	'api_key'			=>	'a.Z9FcC,_-@zo4sRc-A,yP-_', # Change this to your own key
	'cachePath'			=>	'../Cache',
	'cacheTime'			=>	0,
	'lottery'			=>	[100, 70],
	'error_handler'		=>	0, #0 => Native logger, 1 => Whoops logger

	'database'			=>	[ # Set up the database
		'driver'		=>	'mysql',
		'host'		=>		'127.0.0.1',
		'user'		=>		'fasty_user',
		'password'	=>		'fasty_password',
		'database'	=>		'fasty_database'
	],
	'devpages'			=>	[],
	'disablecookies'	=>	[]
];
?>
