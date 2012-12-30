----
33. strlen() vs. isset() zum prüfen einer Stringlänge
---
Beispiel
-------
```php
<?php
$times = array();
$count = 5000;
$foo   = 'abcd';
for($i = 1; $i <= $count; $i++)
{
	$s = microtime(true);
	if (strlen($foo) < 5) { $string = "Foo is too short"; }
	$e = microtime(true);
	$times[$i]['len'] = $e - $s;
	
	$s = microtime(true);
	if (!isset($foo{5})) { $string = "Foo is too short"; }
	$e = microtime(true);
	$times[$i]['c']	= $e - $s;
	$times[$i]['diff']	= $times[$i]['c'] - $times[$i]['len'];
}

foreach($times as $key=>$time)
{
	$tmp['len']		+= $time['len'];
	$tmp['c']		+= $time['c'];
	$tmp['diff']	+= $time['diff'];
	
	echo $key." | ".$time['c']." | ".$time['len']." | ".$time['diff']."<br>";
}

$tmp['len']		= $tmp['len'] / $count;
$tmp['c']		= $tmp['c'] / $count;
$tmp['diff']	= $tmp['diff'] / $count;
$tmp['proz']	= (( $tmp['len'] / $tmp['c']) - 1)*100 ;

echo "<br>".$tmp['c']." | ".$tmp['len']." | ".$tmp['diff']." | ".$tmp['proz']."<br>";
?>
```

Ergebnis
--------

siehe [data.md](data.md)

Kommentar
---------
isset() ist ein PHP Sprachkonstrukt ähnlich wie echo(), deshalb ist es von Haus aus schon mal etwas schneller als strlen().

Performance
-----------
Die Kombination aus der C-Variablen Notation und dem Sprachkonstrukt isset() bringt eine Verbesserung der Performance von ca. 60%.

Ergebnis
-------
###### Anzahl | isset() | strlen() | Differenz
```
1 | 1.90734863281E-6 | 5.00679016113E-6 | -3.09944152832E-6
2 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
3 | 9.53674316406E-7 | 9.53674316406E-7 | 0
4 | 9.53674316406E-7 | 9.53674316406E-7 | 0
5 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
6 | 9.53674316406E-7 | 9.53674316406E-7 | 0
7 | 9.53674316406E-7 | 9.53674316406E-7 | 0
8 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
9 | 0 | 9.53674316406E-7 | -9.53674316406E-7
10 | 9.53674316406E-7 | 9.53674316406E-7 | 0
[...]
```
###### Vollständige Daten: siehe [data.md](data.md)

Fazit
------
Durch die einfach Umsetzung würde ich dazu tendieren die isset() Methode zu verwenden.