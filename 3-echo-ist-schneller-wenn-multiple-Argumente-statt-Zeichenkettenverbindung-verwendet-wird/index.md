---
3. echo ist schneller, wenn multiple Argumente statt Zeichenkettenverbindung verwendet wird
---

Beispiel
--------
```php
<?php
$str1 = <<< EOT
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

EOT;

$str2 = <<< EOT
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

EOT;

$str3 = <<< EOT
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. 

Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 

Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. 

EOT;
$zeiten = array();

for($i = 0; $i < 10; $i++)
{
	$s = microtime(true);
	echo $str1 . " " . $str2 . " " . $str3;
	$e = microtime(true);
	$zeiten[] = sprintf("Zeit echo mit Konkatenation: %1.5f\n", ($e - $s));
	
	$s = microtime(true);
	echo $str1 , " " , $str2 , " " , $str3;
	$e = microtime(true);
	$zeiten[] = sprintf("Zeit echo mit mehreren Parametern: %1.5f\n", ($e - $s));
}
foreach($zeiten as $zeit) echo $zeit;
?>
```
Ergebnis
--------

siehe [data.md](data.md)

Kommentar
---------

echo ist ein in der PHP-Laufzeit direkt implementiertes Konstrukt. Es ist möglich einen oder mehrere Parameter zu übergeben. 
Zeichenketten-Verbindung wird mit dem Konkatenationsoperator (.) vorgenommen.

Performance
-----------

Bei Messung mit dem obigen Code konnte die Mehr-Parameter-Lösung tatsächlich schneller abschließen, wie den Resultaten zu entnehmen ist.

Ergebnis
--------
	Zeit echo mit Konkatenation: 0.00024
	Zeit echo mit mehreren Parametern: 0.00003
	Zeit echo mit Konkatenation: 0.00088
	Zeit echo mit mehreren Parametern: 0.00004
	Zeit echo mit Konkatenation: 0.00022
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00024
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00019
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00017
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00030
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00019
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00017
	Zeit echo mit mehreren Parametern: 0.00002
	Zeit echo mit Konkatenation: 0.00018
	Zeit echo mit mehreren Parametern: 0.00002

Fazit
-----
echo mit mehreren Parametern kann einen geringfügigen Performance-Zuwachs bedeuten. Besonders bei Appliktationen, die von vielen Usern gleichzeitig benutzt wird, kann hier Leistung rausgekitzelt werden.
