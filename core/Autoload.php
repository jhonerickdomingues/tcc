<?php

class Autoload
{
	protected static $dirs = [
		'controllers',
		'core',
		'authenticate',
		'database',
		'helpers',
		'html',
		'functions'
	];

	protected static $files_not = [
		'index.php',
		'config.php',
		'bootstrap.php',
		'Autoload.php',
		'.htaccess',
        'routes.php',
        'package-lock.json',
		'..',
		'.'
	];

	public static function load($directory = '.')
	{
		$dir = scandir($directory);
        rsort($dir);
		foreach($dir as $value)
		{
			if(!is_array($directory.DIRECTORY_SEPARATOR.$value))
			{

				if(is_file($directory.DIRECTORY_SEPARATOR.$value) && !in_array($value, self::$files_not))
				{
					require $directory.DIRECTORY_SEPARATOR.$value;
				}
				
				if(is_dir($directory.DIRECTORY_SEPARATOR.$value) && in_array($value, self::$dirs))
				{
					self::load($directory.DIRECTORY_SEPARATOR.$value);
				}
			}
		}
	}
}