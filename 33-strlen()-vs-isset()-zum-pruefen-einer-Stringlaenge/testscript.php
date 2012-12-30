<?php
$times = array();
$count = 500;
$foo   = 'abcd';
for($i = 0; $i <= $count; $i++)
{
	$s = microtime(true);
	if (strlen($foo) < 5) { $string = "Foo is too short"; }
	$e = microtime(true);
	$times[$i]['len'] = sprintf("%1.8f", $e - $s);

	$s = microtime(true);
	if (!isset($foo{5})) { $string = "Foo is too short"; }
	$e = microtime(true);
	$times[$i]['c']	= sprintf("%1.8f", $e - $s);
	$times[$i]['diff']	= sprintf("%1.8f", $times[$i]['c'] - $times[$i]['len']);
}
