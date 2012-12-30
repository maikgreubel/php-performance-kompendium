<?php
$times = array();
for($i = 0; $i <= 500; $i++)
{
	$a = null;

	$s = microtime(true);
	++$a;
	$e = microtime(true);
	$times[$i]['++var'] = sprintf("%1.8f", $e - $s);


	$s = microtime(true);
	$a++;
	$e = microtime(true);

	$times[$i]['var++'] 		= sprintf("%1.8f", $e - $s);
	$times[$i]['difference']	= sprintf("%1.8f", $times[$i]['++var'] - $times[$i]['var++']);
}
