-----
23. Definierte Variablen lassen sich schneller inkrementierne als undefinierte Variablen
-----

Beispiel
--------
```php
<?php
$times = array();

for($i = 0; $i <= 4999; $i++)
{
	$a = NULL;
	$s = microtime(true);
	$a++;
	$e = microtime(true);
	$times[$i]['defined']		= $e - $s;
	
	unset($a);
	
	$s = microtime(true);
	$a++;
	$e = microtime(true);
	
	$times[$i]['undefined']		= $e - $s;
	$times[$i]['differences']	= $times[$i]['defined'] - $times[$i]['undefined'];
}
include("classes/class.markdown.php");
$markdown = new markdown($times);
$markdown->write();
?>
```

Performance
-----------
Tatsächlich lässt sich eine deutliche Steigerung der Performance feststellen. Sie liegt bei ca. 160%.

Fazit
------
Zwar kann nicht die genannte Steigerung von 1000% erreicht werden allerdings sind 160% eine durchaus bemerkenswerte Steigerung.