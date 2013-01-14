----
9. $_SERVER['REQUEST_TIME'] sollte gegenüber time() bevorzugt werden.
----

Beispiel
--------
```php
<?php
$times = array();

for($i = 0; $i <= 5000; $i++)
{
	$s		= microtime(true);
	$time	= $_SERVER['REQUEST_TIME'];
	$e 		= microtime(true);

	$times[$i]['REQUEST_TIME'] = $e - $s;
	
	$s		= microtime(true);
	$time	= time();
	$e		= microtime(true);
	
	$times[$i]['time()']	= $e - $s;
	$times[$i]['difference'] = $times[$i]['REQUEST_TIME'] - $times[$i]['time()'];
	
}
include("classes/class.markdown.php");
$markdown = new markdown($times);
$markdown->write();
?>
```
Kommentar
---------
Der Timestamp des Beginns der aktuellen Anfrage steht seit PHP 5.1 in der Variablen $_SERVER['REQUEST_TIME'] zur Verfügung. [1](http://de3.php.net/manual/de/function.time.php#refsect1-function.time-notes)

Performance
-----------
Der Performance gewinn liegt bei ca. 20%.

Ergebnis
-------

#### Anzahl | REQUEST_TIME | time() | difference
```
1 | 5.96046447754E-6 | 1.00135803223E-5 | -4.05311584473E-6
2 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
3 | 1.90734863281E-6 | 1.90734863281E-6 | 0
4 | 1.90734863281E-6 | 1.90734863281E-6 | 0
5 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
6 | 2.14576721191E-6 | 2.14576721191E-6 | 0
7 | 9.53674316406E-7 | 2.14576721191E-6 | -1.19209289551E-6
8 | 2.14576721191E-6 | 2.14576721191E-6 | 0
9 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
10 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
[...]
```
siehe [data.md](data.md)

Fazit
------
Sehr sinnvolle Optimierungsmöglichkeit wenn mann die Startzeit eines Scripts benötigt.
