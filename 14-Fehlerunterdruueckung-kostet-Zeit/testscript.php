<?php
$count = 100;
$times = array();
function x() { }

for($a = 0; $a <= $count; $a++)
{
	$s = microtime(true);
	//for ($i = 0; $i < 100000; $i++)
	{
		x();
	}
	$e = microtime(true);

	$times[$a]['nosupression'] = sprintf("%1.8f", $e - $s);

	$s = microtime(true);
	//for ($i = 0; $i < 100000; $i++)
	{
		@x();
	}
	$e = microtime(true);

	$times[$a]['supression'] = sprintf("%1.8f", $e - $s);
	$times[$a]['diff']		 = sprintf("%1.8f", $times[$a]['supression'] - $times[$a]['nosupression']);
}
