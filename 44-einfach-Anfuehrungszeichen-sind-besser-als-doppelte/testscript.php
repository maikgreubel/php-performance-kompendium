<?php
$times = array();
$count = 5000;
for($i = 0; $i <= $count; $i++)
{
	$s = microtime(true);
	$string = "THIS IS A TEST STRING, i want to know which quote type is faster";
	$e = microtime(true);
	$times[$i]['double'] = sprintf("%1.8f", $e - $s);

	$s = microtime(true);
	$string = 'THIS IS A TEST STRING, i want to know which quote type is faster';
	$e = microtime(true);
	$times[$i]['singel']	= sprintf("%1.8f", $e - $s);
	$times[$i]['diff']	= sprintf("%1.8f", $times[$i]['double'] - $times[$i]['singel']);
}
