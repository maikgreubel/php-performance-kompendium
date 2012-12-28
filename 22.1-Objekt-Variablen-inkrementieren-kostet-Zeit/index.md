-----
22. Objekt Variablen inkrementieren kostet Zeit
-----

Beispiel
--------
```php
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

for($i = 0; $i <= 4999; $i++)
{
	$a = null;
	$s = microtime(true);
	$a++;
	$e = microtime(true);
	$times[$i]['local_var'] = $e - $s;
	
	
	$s = microtime(true);
	$b->increment();
	$e = microtime(true);
	
	$times[$i]['obj_property'] 	= $e - $s;
	$times[$i]['difference']	= $times[$i]['local_var'] - $times[$i]['obj_property'];
}

include("classes/class.markdown.php");
$markdown = new markdown($times);
$markdown->write();
?>
```

Kommentar
---------
Ob dieser Vergleich sinnvoll bzw. Aussagekräftig ist bezweifele ich.

Performance
-----------
Die lokale Inkrementation ist ca. 100% schneller.

Ergebnis
---------
#### Anzahl | local_var | obj_property | difference
```
1 | 2.14576721191E-6 | 5.00679016113E-6 | -2.86102294922E-6
2 | 0 | 9.53674316406E-7 | -9.53674316406E-7
3 | 9.53674316406E-7 | 9.53674316406E-7 | 0
4 | 1.19209289551E-6 | 1.90734863281E-6 | -7.15255737305E-7
5 | 9.53674316406E-7 | 2.14576721191E-6 | -1.19209289551E-6
6 | 9.53674316406E-7 | 1.90734863281E-6 | -9.53674316406E-7
7 | 0 | 1.90734863281E-6 | -1.90734863281E-6
8 | 0 | 2.14576721191E-6 | -2.14576721191E-6
9 | 0 | 9.53674316406E-7 | -9.53674316406E-7
10 | 9.53674316406E-7 | 9.53674316406E-7 | 0
[...]
```
siehe [data.md](data.md)
Fazit
-----
Mit Vorsicht zu genießen.

