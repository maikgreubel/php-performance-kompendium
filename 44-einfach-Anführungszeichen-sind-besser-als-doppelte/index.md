------
44. einfach Anführungszeichen sind besser als doppelte
------
Beispiel
--------
```php
<?php
$times = array();
$count = 5000;
for($i = 1; $i <= $count; $i++)
{
	$s = microtime(true);
	$string = "THIS IS A TEST STRING, i want to know which quote type is faster";
	$e = microtime(true);
	$times[$i]['double'] = $e - $s;
	
	$s = microtime(true);
	$string = 'THIS IS A TEST STRING, i want to know which quote type is faster';
	$e = microtime(true);
	$times[$i]['singel']	= $e - $s;
	$times[$i]['diff']	= $times[$i]['double'] - $times[$i]['singel'];
}

foreach($times as $key=>$time)
{
	$tmp['double']		+= $time['double'];
	$tmp['singel']		+= $time['singel'];
	$tmp['diff']	+= $time['diff'];
	
	echo $key." | ".$time['double']." | ".$time['singel']." | ".$time['diff']."<br>";
}

$tmp['double']		= $tmp['double'] / $count;
$tmp['singel']		= $tmp['singel'] / $count;
$tmp['diff']	= $tmp['diff'] / $count;
$tmp['proz']	= (( $tmp['double'] / $tmp['singel']) - 1)*100 ;

echo "<br>".$tmp['double']." | ".$tmp['singel']." | ".$tmp['diff']." | ".$tmp['proz']."<br>";
?>
```
Kommentar
----------
Vor allem ist die Verwendung von einfachen Anführungszeichen bei der Ausgabe von HTMl-Code besonders sinnvoll, weil man sich das escapen der HTML-Attribute sparen kann.

Performance
-----------
Einfach Anführungszeichen sind im Schnitt ca. 5% schneller als doppelte.

Ergebnis
---------
###### Anzahl | double | single | Differenz
```
1 | 3.09944152832E-6 | 9.53674316406E-7 | 2.14576721191E-6
2 | 0 | 0 | 0
3 | 1.19209289551E-6 | 9.53674316406E-7 | 2.38418579102E-7
4 | 0 | 0 | 0
5 | 9.53674316406E-7 | 9.53674316406E-7 | 0
6 | 9.53674316406E-7 | 9.53674316406E-7 | 0
7 | 1.19209289551E-6 | 0 | 1.19209289551E-6
8 | 9.53674316406E-7 | 9.53674316406E-7 | 0
9 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
10 | 9.53674316406E-7 | 9.53674316406E-7 | 0
[...]
```
###### Vollständige Daten: siehe [data.md](data.md)

Fazit
------
Zwar ist der effektive Performance Zugewinn eher gering, allerdings gerade in Kombination mit HTML-Code interesannt.
