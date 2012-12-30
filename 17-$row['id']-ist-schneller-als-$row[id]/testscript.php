<?php
// To be more realistic (most users would have deactivated error reporting)
error_reporting(0);
$zeiten = array();
$count = 100;
for($i = 1; $i <= $count; $i++)
{
	$s = microtime(true);
	$arry[id] = 'THIS IS AN VERY USELESS STRING';
	$e = microtime(true);
	$zeiten[$i]['noqout'] = sprintf("%1.8f", $e - $s);

	$s = microtime(true);
	$arry['id'] = 'THIS IS AN VERY USELESS STRING';
	$e = microtime(true);

	$zeiten[$i]['qout'] = sprintf("%1.8f", $e - $s);
	$zeiten[$i]['diff'] = sprintf("%1.8f", $zeiten[$i]['noqout'] - $zeiten[$i]['qout']);
}
