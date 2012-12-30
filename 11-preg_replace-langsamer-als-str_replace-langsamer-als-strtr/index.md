---
11. preg\_replace ist langsamer als str_replace ist langsamer als strtr
---

Beispiel
--------
```php
<?php
/* Hier startet der Test */
$zeiten = array();

$var = 'Hallo Welt';

/* Die Geschäfs-Ausgaben interessieren uns hier nicht */
ob_start();

for($i = 0; $i < 10; $i++)
{
  /* Test-Teil 1: preg_replace */
  $s = microtime(true);
  echo preg_replace('/a/', 'e', $var) . "\n";
  $e = microtime(true);
  $zeiten[] = sprintf("Zeit preg_replace: %1.8f\n", ($e-$s));

  /* Test-Teil 2: str_replace */
  $s = microtime(true);
  echo str_replace('a', 'e', $var) . "\n";
  $e = microtime(true);
  $zeiten[] = sprintf("Zeit str_replace: %1.8f\n", ($e-$s));

  /* Test-Teil 3: strtr */
  $s = microtime(true);
  echo strtr($var, 'a', 'e') . "\n";
  $e = microtime(true);
  $zeiten[] = sprintf("Zeit strtr: %1.8f\n", ($e-$s));
}

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();

/* Resultate anzeigen */
foreach($zeiten as $zeit) echo $zeit;
```

Kommentar
---------

Die Funktionen erledigen in diesem Beispiel alle das selbe: 'a' wird durch 'e' ersetzt. Da strtr() nur die Buchstaben tauscht und keine ganzen Wortteile oder Wörter, ist sein Einsatzgebiet auf diese Anwendung beschränkt.

Performance
-----------

Das strtr immer 4 mal schneller ist als str_replace, ist ein Irrtum, wenn man die Resultate betrachtet.

siehe [data.md](data.md)

Fazit
-----
Es gibt dutzende Zeichenketten-Manipulationsfunktionen, die ähnlich arbeiten oder zu mindest Teilaspekte ähnlich sind. Die Laufzeiten der einzelnen Funktionen können abhängig von der Mächtigkeit der Funktion stark variieren.