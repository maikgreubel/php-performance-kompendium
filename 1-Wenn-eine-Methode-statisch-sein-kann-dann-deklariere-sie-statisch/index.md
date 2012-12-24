---
1. Wenn eine Funktion oder Methode statisch sein kann, dann deklariere sie statisch
---

Beispiel
--------
```php
<?php
class calc
{
	public static function a_plus_b($a, $b)
	{
		$c = $a+$b;
		return $c;
	}
}
$zeiten = array();
for($i = 0; $i < 10; $i++)
{
	$s = microtime(true);
	echo calc::a_plus_b(5, 6) . "\n";
	$e = microtime(true);
	$zeiten[] = sprintf ("Zeit statisch 1: %1.5f\n", ($e - $s));
	
	$s = microtime(true);
	echo calc::a_plus_b(7, 8) . "\n";
	$e = microtime(true);
	$zeiten[] = sprintf ("Zeit statisch 2: %1.5f\n", ($e - $s));
	
	$s = microtime(true);
	$c = new calc();
	echo $c->a_plus_b(9, 2) . "\n";
	$e = microtime(true);
	$zeiten[] = sprintf ("Zeit instanziiert 1: %1.5f\n", ($e - $s));
	
	$s = microtime(true);
	echo $c->a_plus_b(3, 4) . "\n";
	$e = microtime(true);
	$zeiten[] = sprintf ("Zeit instanziiert 2: %1.5f\n", ($e - $s));
}
foreach($zeiten as $zeit) echo $zeit;
?>
```

Kommentar
---------

Wenn eine Klassen-Methode statisch deklariert ist, bedeutet das nicht, dass man diese Methode nicht auch als Instanz aufrufen kann.

Performance
-----------

Unterschiedliche Messergebnisse können das prognostizierte Verhalten nicht widergeben. Teilweise ist die statische Variante langsamer als die Instanz-Variante.

Ergebnis
--------
	Zeit statisch 1: 0.00007
	Zeit statisch 2: 0.00003
	Zeit instanziiert 1: 0.00002
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00002
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00002
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001
	Zeit statisch 1: 0.00001
	Zeit statisch 2: 0.00001
	Zeit instanziiert 1: 0.00001
	Zeit instanziiert 2: 0.00001

Fazit
-----
Mit Vorsicht zu geniesen, kommt wahrhscheinlich auch auf den Code innerhalb der Funktion an.