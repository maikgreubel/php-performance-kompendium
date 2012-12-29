-----
34. Prä-Inkrement ist schneller als Post-Inkrement
-----
Breispiel
---------
```php
<?php
$times = array();
for($i = 0; $i <= 4999; $i++)
{
	$a = null;
	
	$s = microtime(true);
	++$a;
	$e = microtime(true);
	$times[$i]['++var'] = $e - $s;
	
	
	$s = microtime(true);
	$a++;
	$e = microtime(true);
	
	$times[$i]['var++'] 		= $e - $s;
	$times[$i]['difference']	= $times[$i]['++var'] - $times[$i]['var++'];
}

include("classes/class.markdown.php");
$markdown = new markdown($times);
$markdown->write();
?>
```

Kommentar
---------
- Prä-Inkrement : Erhöht den Wert von $a um eins (inkrementiert $a) und gibt anschließend den neuen Wert von $a zurück.
- Post-Inkrement : Gibt zuerst den aktuellen Wert von $a zurück und erhöht dann den Wert von $a um eins.  

Performance
-----------
Kaum messbarer Zuwachs an Performance. (ca. 2%)
Ergebnis
--------

#### Anzahl | ++var | var++ | difference
```
1 | 1.90734863281E-6 | 9.53674316406E-7 | 9.53674316406E-7
2 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
3 | 0 | 9.53674316406E-7 | -9.53674316406E-7
4 | 1.19209289551E-6 | 9.53674316406E-7 | 2.38418579102E-7
5 | 1.19209289551E-6 | 0 | 1.19209289551E-6
6 | 9.53674316406E-7 | 9.53674316406E-7 | 0
7 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
8 | 9.53674316406E-7 | 9.53674316406E-7 | 0
9 | 9.53674316406E-7 | 0 | 9.53674316406E-7
10 | 9.53674316406E-7 | 0 | 9.53674316406E-7
[...]
```
siehe [data.md](data.md)
Fazit
------
Aufgrund des marginalen Unterschieds und der Auswirkung auf den Script rate ich von der Anwendung ab.