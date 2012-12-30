-----
18. Fehlermeldungen sind teuer
-----

Beispiel
--------
```php
$zeiten = array();
$test_count = 100;

/* Preparation */
$fd = fopen('test-file.txt', 'w');
if(!$fd)
{
  throw new Exception('File test-file.txt could not be created!');
}
fclose($fd);

/* Test start */

for($i = 0; $i < $test_count; $i++)
{
  $s = microtime(true);
  $fd = fopen('test-file-not-exist.txt', 'r');
  $content = fread($fd, 100);
  fclose($fd);
  $e = microtime(true);
  
  $zeiten[$i]['with_error_message'] = sprintf("%1.8f", $e-$s);
  
  $s = microtime(true);
  if(file_exists('test-file-not-exist.txt'))
  {
    $fd = fopen('test-file-not-exist.txt', 'r');
    $content = fread($fd, 100);
    fclose($fd);
  }
  $e = microtime(true);
  
  $zeiten[$i]['with_previous_check'] = sprintf("%1.8f", $e-$s);

  $s = microtime(true);
  if(file_exists('test-file.txt'))
  {
    $fd = fopen('test-file.txt', 'r');
    $content = fread($fd, 100);
    fclose($fd);
  }
  $e = microtime(true);
  
  $zeiten[$i]['without_error'] = sprintf("%1.8f", $e-$s);
}

/* Cleanup */
unlink('test-file.txt');
```

Kommentar
---------
Es ist grundsätzlich eine gute Idee, sog. Pre-Checks und Post-Checks für bestimmte Operationen zu verwenden. Das ist nicht nur ein sauberer Stil sondern hilft bei der Fehleranalyse und nicht zu letzt wird die Laufzeit auch geschont.

Performance
-----------
Der Overhead für einen Check sollte unbedingt in Kauf genommen werden, er ist im Vergleich zu evtl. Fehlermeldungen zu vernachlässigen.
Auf jeden Fall ist das Resultat für die Laufzeit sehr gut, wenn evtl. Probleme schon vor dem Ausführen bestimmter Aktionen gefunden werden.

Ergebnis
--------

siehe [data.md](data.md)

Fazit
-----
Im Beispiel geht es um Operationen im Dateisystem. Gerade beim Zugriff auf Resourcen sollten Fehlerbehandlungen eingebaut werden.

Der Code im Beispiel ist noch nicht optimal, es können noch Prüfungen für das erfolgreiche Öffnen der Dateien eingebaut werden, bisher wird nur deren Existenz geprüft. Dem Leser sei ein Test in dieser Richtung selbst überlassen.

**Prüfungen auf Plausibilität sind unerlässlich!**
