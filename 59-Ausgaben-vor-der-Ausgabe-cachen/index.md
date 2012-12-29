-----
59. Ausgaben vor der Ausgabe cachen
-----

Beispiel
--------
```php
<?php
$array	= array();
for($i = 0; $i <= 4999; $i++)
{
	ob_start();
	$s	= microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br>";
	$e	= microtime(true);
	ob_clean();
	ob_end_flush();
	
	$array[$i]['ob_start'] = $e - $s;
	
	$s = microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br>";
	$e = microtime(true);
	
	$array[$i]['no_cache']		= $e - $s;
	$array[$i]['difference']	= $array[$i]['ob_start'] - $array[$i]['no_cache'];
}

require("classes/class.markdown.php");
$dataMD = new markdown($array);
$dataMD->write();
?>
```

Kommentar
---------
Es ist durchaus sinnvoll bei der Ausgabe von längeren Strings caching zu verwenden.

Performance
-----------

Mit dem von PHP gegebenen Caching Methoden ist ein Leistungszuwachs von ca. 80% erkennbar.

Ergebnis
--------

```
1 | 3.09944152832E-6 | 4.05311584473E-6 | -9.53674316406E-7
2 | 0 | 9.53674316406E-7 | -9.53674316406E-7
3 | 0 | 1.19209289551E-6 | -1.19209289551E-6
4 | 1.19209289551E-6 | 9.53674316406E-7 | 2.38418579102E-7
5 | 9.53674316406E-7 | 9.53674316406E-7 | 0
6 | 1.19209289551E-6 | 9.53674316406E-7 | 2.38418579102E-7
7 | 9.53674316406E-7 | 9.53674316406E-7 | 0
8 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
9 | 9.53674316406E-7 | 9.53674316406E-7 | 0
10 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
[...]
```

siehe [data.md](data.md)

Fazit
------
Durchaus sinnvolle Möglichkeit PHP-Applikationen zu beschleunigen.