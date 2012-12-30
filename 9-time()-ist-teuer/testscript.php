<?php
$times = array();

for($i = 0; $i <= 500; $i++)
{
	$s		= microtime(true);
	$time	= $_SERVER['REQUEST_TIME'];
	$e 		= microtime(true);

	$times[$i]['REQUEST_TIME'] = sprintf("%1.8f", $e - $s);

	$s		= microtime(true);
	$time	= time();
	$e		= microtime(true);

	$times[$i]['time()']	= sprintf("%1.8f", $e - $s);
	$times[$i]['difference'] = sprintf("%1.8f", $times[$i]['REQUEST_TIME'] - $times[$i]['time()']);

}
