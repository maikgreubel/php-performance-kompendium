---
2. echo ist schneller als print
---

Beispiel
--------
```php
<?php
$startE = microtime(true);
for($i = 0; $i <= 100000; $i++)
{
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br>";
}
$endE = microtime(true);
$startP = microtime(true);
for($i = 0; $i <= 100000; $i++)
{
  print("Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br>");
}
$endP = microtime(true);

$time2 = $endE - $startE;
$time1 = $endP - $startP;
$time3 = $time2 - $time1;
echo $time1."<br>".$time2."<br>".$time3;
?>
```
Kommentar
_________
Je nach dem wie die PHP-Einstellungen bzw. der Server Hardwaretechnisch ausgestattet ist sind die Werte variabel.

Performance
-----------

Anhand der Messergebnisse ist klar ersichtlich das echo() schneller als print() ist

Ergebnis
-----------
	Anzahl | echo | print | difference
	1  0.154245853424 | 0.205929994583 | 0.05168414
	2  0.145735979080 | 0.208928823471 | 0.06319284
	3  0.200348854065 | 0.225757837296 | 0.0254089832306
	4  0.165272951126 | 0.235462903976 | 0.0701899528503
	5  0.173442125320 | 0.225005865097 | 0.0515637397766
	6  0.153725147247 | 0.230386018753 | 0.0766608715057
	7  0.158454895020 | 0.221489906311 | 0.0630350112915
	8  0.173126935959 | 0.223783969879 | 0.0506570339203
	9  0.161698102951 | 0.239491939545 | 0.0777938365936
	10 0.182342052460 | 0.225814819336 | 0.0434727668762

siehe [data.md](data.md)

Fazit
------

Generell würde ich dazu tendieren echo() für die Ausgabe von längeren Strings zu verwenden. Um generell die Ausgabe von Texten mit PHP zu beschleunigen würde ich zusätzlich den Befehl [ob_start()] [1] verwenden.
[1]: http://de3.php.net/manual/de/function.ob-start.php "ob_start()"
