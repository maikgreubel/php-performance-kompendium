---
4. End-Wert als Abbruchbedingung in for-Schleifen vor dem Eintritt in die Schleife festlegen
---

Beispiel
--------
```php
<?php
// Bitte die erste for-Schleife ignorieren, nur f�r die Vorbereitung des Tests notwendig
$testdata = array();
for($i = 0; $i < 10000; $i++)
{
$testdata[] = $i * 31 ^ ($i-1);
}

// Hier startet der Test
$zeiten = array();
$t = 0;
$s = microtime(true);
for($n = 0; $n < count($testdata); $n++)
{
$t = $t + $testdata[$n];
}
$e = microtime(true);
$zeiten[] = sprintf("Zeit for count max value: %1.5f\n", ($e-$s));

$t = 0;
$s = microtime(true);
for($n = 0, $k = count($testdata); $n < $k; $n++)
{
$t = $t + $testdata[$n];
}
$e = microtime(true);
$zeiten[] = sprintf("Zeit for fixed max value: %1.5f\n", ($e-$s));

foreach($zeiten as $zeit) echo $zeit;
?>
```
Kommentar
---------

Die Abbruch-Bedingung einer Schleife muss nach jedem Durchlauf neu gepr�ft werden. Daher ist es ratsam, die Pr�fung mit konstanten Werten durchzuf�hren.

Performance
-----------

Konstante Werte in der Abbruchbedingung beschleunigen die Pr�fung.

Ergebnis
--------
	Zeit for count max value: 0.00714
	Zeit for fixed max value: 0.00278

Fazit
-----
Bei Schleifen mit langer Laufzeit kann der Performance-Gewinn sp�rbar werden.