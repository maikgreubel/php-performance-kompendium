<?php
function theCalc($a,$b)
{
	$c = $a * $b;
	$c = $c * $c;
	$c = $c / ($a*$b);
	return $c;
}

$times	= array();
$result	= array();

for($i = 0; $i <= 100; $i++)
{
	$value 		= $i + 2;

	$start		= (double)microtime(true);
	$result[$i]	= theCalc($i+1,$value);
	$end		= (double)microtime(true);

	$times[$i]['func_time']  = sprintf("%1.8f", $end - $start);

	unset($end);
	unset($start);

	$start		= (double)microtime(true);
	$c 			= ($i+1) * $value;
	$c 			= $c * $c;
	$c 			= $c / (($i+1)*$value);
	$result[$i] = $c;
	$end		= (double)microtime(true);

	$times[$i]['code_time']  = sprintf("%1.8f", $end - $start);
	$times[$i]['diff']			= sprintf("%1.8f", $times[$i]['func_time'] - $times[$i]['code_time']);
}
