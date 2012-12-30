<?php
class calc
{
	public static function a_plus_b($a, $b)
	{
		$c = $a+$b;
		return $c;
	}
}

$zeiten = array();
ob_start();
for($i = 0; $i < 10; $i++)
{
	$s = microtime(true);
	echo calc::a_plus_b(5, 6) . "\n";
	$e = microtime(true);
	$zeiten[$i]['static 1'] = sprintf ("%1.8f", ($e - $s));
	
	$s = microtime(true);
	echo calc::a_plus_b(7, 8) . "\n";
	$e = microtime(true);
	$zeiten[$i]['static 2'] = sprintf ("%1.8f", ($e - $s));
	
	$s = microtime(true);
	$c = new calc();
	echo $c->a_plus_b(9, 2) . "\n";
	$e = microtime(true);
	$zeiten[$i]['instance 1'] = sprintf ("%1.8f", ($e - $s));
	
	$s = microtime(true);
	echo $c->a_plus_b(3, 4) . "\n";
	$e = microtime(true);
	$zeiten[$i]['instance 2'] = sprintf ("%1.8f", ($e - $s));
}

ob_end_clean();