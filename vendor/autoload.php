<?php
/**
 * Register the autoloader for the global classes.
 * Based off the official PSR-4 autoloader example found here:
 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 * 
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class)
{
	// project-specific namespace prefix
	$prefix = 'ufozone\\phpsepa\\';
	
	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0)
	{
		// no, move to the next registered autoloader
		return;
	}
	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = __DIR__ . '/lib/' . str_replace('\\', '/', substr($class, $len)) . '.php';
	
	// if the file exists, require it
	if (file_exists($file))
	{
		require $file;
	}
});
