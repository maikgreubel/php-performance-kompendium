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

Ergebnis
--------
#### Anzahl | defined | undefined | differences

```
1 | 3.09944152832E-6 | 5.00679016113E-6 | -1.90734863281E-6
2 | 9.53674316406E-7 | 3.09944152832E-6 | -2.14576721191E-6
3 | 9.53674316406E-7 | 2.14576721191E-6 | -1.19209289551E-6
4 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
5 | 0 | 1.90734863281E-6 | -1.90734863281E-6
6 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
7 | 0 | 9.53674316406E-7 | -9.53674316406E-7
8 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
9 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
10 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
[...]
```
siehe [data.md](data.md)
Fazit
------
Zwar kann nicht die genannte Steigerung von 1000% erreicht werden allerdings sind 160% eine durchaus bemerkenswerte Steigerung.