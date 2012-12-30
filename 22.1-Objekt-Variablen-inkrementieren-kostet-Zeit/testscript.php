<?php
$times = array();
class b
{
	public $counter;

	public function increment()
	{
		$this->counter++;
	}
}

$b = new b;

for($i = 0; $i < 500; $i++)
{
	$a = null;
	$s = microtime(true);
	$a++;
	$e = microtime(true);
	$times[$i]['local_var'] = sprintf("%1.8f", $e - $s);


	$s = microtime(true);
	$b->increment();
	$e = microtime(true);

	$times[$i]['obj_property'] 	= sprintf("%1.8f", $e - $s);
	$times[$i]['difference']	= sprintf("%1.8f", $times[$i]['local_var'] - $times[$i]['obj_property']);
}
