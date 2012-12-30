<?php
$zeiten = array();

$g_i = 0;

class A
{
	private $i;

	public function inc($zeiten = array(), $current)
	{
		global $g_i;
		$a = 0;
		$s = microtime(true);
		$a++;
		$e = microtime(true);
		$zeiten[$current]['lokal'] = sprintf("%1.8f", $e-$s);

		$s = microtime(true);
		$this->i++;
		$e = microtime(true);
		$zeiten[$current]['member'] = sprintf("%1.8f", $e-$s);

		$s = microtime(true);
		$g_i++;
		$e = microtime(true);
		$zeiten[$current]['global'] = sprintf("%1.8f", $e-$s);

		return $zeiten;
	}
}

$anzahl_loops = 500;

$a = new A();

for($i = 0; $i < $anzahl_loops; $i++)
{
	$zeiten = $a->inc($zeiten, $i);
}
