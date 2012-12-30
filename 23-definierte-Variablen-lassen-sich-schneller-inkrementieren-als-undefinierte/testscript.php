<?php
// Don't use error_reporting
error_reporting(0);

$times = array();

for($i = 0; $i < 500; $i++)
{
	$a = NULL;
	$s = microtime(true);
	$a++;
	$e = microtime(true);
	$times[$i]['defined'] = sprintf("%1.8f", $e - $s);

	unset($a);

	$s = microtime(true);
	$a++;
	$e = microtime(true);

	$times[$i]['undefined']		= sprintf("%1.8f", $e - $s);
	$times[$i]['differences']	= sprintf("%1.8f", $times[$i]['defined'] - $times[$i]['undefined']);
}
