#!/usr/bin/env php
<?php
require_once ('PHPFormatter.php');
if (!isset($argv[1])) {
	exit();
}

array_shift($argv);
while (($uri = array_shift($argv))) {
	if (is_file($uri)) {
		$fmt = new PHPFormatter();
		file_put_contents($uri.'-tmp', $fmt->formatCode(file_get_contents($uri)));
		rename($uri, $uri.'~');
		rename($uri.'-tmp', $uri);
	} else {
		$dir = new RecursiveDirectoryIterator($uri);
		$it = new RecursiveIteratorIterator($dir);
		$files = new RegexIterator($it, '/^.+\.in$/i', RecursiveRegexIterator::GET_MATCH);
		foreach ($files as $file) {
			$file = $file[0];
			echo $file;
			$fmt = new PHPFormatter();
			file_put_contents($file.'-tmp', $fmt->formatCode(file_get_contents($file)));
			rename($file, $file.'~');
			rename($file.'-tmp', $file);
			echo PHP_EOL;
		}
	}
}
