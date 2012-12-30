<?php
$zeiten = array();
$test_count = 100;

/* Preparation */
$fd = fopen('test-file.txt', 'w');
if(!$fd)
{
	throw new Exception('File test-file.txt could not be created!');
}
fclose($fd);

/* Test start */

for($i = 0; $i < $test_count; $i++)
{
	$s = microtime(true);
	$fd = fopen('test-file-not-exist.txt', 'r');
	$content = fread($fd, 100);
	fclose($fd);
	$e = microtime(true);
	
	$zeiten[$i]['with_error_message'] = sprintf("%1.8f", $e-$s);
	
	$s = microtime(true);
	if(file_exists('test-file-not-exist.txt'))
	{
		$fd = fopen('test-file-not-exist.txt', 'r');
		$content = fread($fd, 100);
		fclose($fd);
	}
	$e = microtime(true);
	
	$zeiten[$i]['with_previous_check'] = sprintf("%1.8f", $e-$s);

	$s = microtime(true);
	if(file_exists('test-file.txt'))
	{
		$fd = fopen('test-file.txt', 'r');
		$content = fread($fd, 100);
		fclose($fd);
	}
	$e = microtime(true);
	
	$zeiten[$i]['without_error'] = sprintf("%1.8f", $e-$s);
}

/* Cleanup */
unlink('test-file.txt');
