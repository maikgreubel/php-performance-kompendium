---
22. Lokale Variablen sind schneller zu inkrementieren als Klassen-Mitgliedsvariablen
---

Beispiel
--------
```php
<?php
$g_i = 0;

class A
{
	private $i;
	
	public function inc($zeiten = array())
	{
		global $g_i;
		$a = 0;
		$s = microtime(true);
		$a++;
		$e = microtime(true);
		$zeiten['lokal'] += ($e-$s);
		
		$s = microtime(true);
		$this->i++;
		$e = microtime(true);
		$zeiten['member'] += ($e-$s);
		
		$s = microtime(true);
		$g_i++;
		$e = microtime(true);
		$zeiten['global'] += ($e-$s);
		
		return $zeiten;
	}
}

$anzahl_loops = 10000;
$zeiten = array('lokal' => 0.0, 'member' => 0.0, 'global' => 0.0);

$a = new A();

for($i = 0; $i < $anzahl_loops; $i++)
{
	$zeiten = $a->inc($zeiten);
}
foreach($zeiten as $indikator => $zeit) printf("%s: %1.10f\n", $indikator, ($zeit / $anzahl_loops));
```

Kommentar
---------
Wenn man innerhalb von Klassen-Methoden Schleifen durchlaufen lassen möchte, kann man sich natürlich zwischen Klassen-Mitgliedsvariablen und lokalen entscheiden. Von globalen Variablen sollte man Abstand nehmen, zu groß sind die Verwirrungen, wenn von mehren Codestellen darauf (ändernt) zugegriffen wird. Im Beispiel werden alle drei Möglichkeiten gezeigt.

Performance
-----------
wie im Referenz-Artikel beschrieben, ist der Zugriff auf Mitgliedsvariablen etwas langsamer als der Zugriff auf lokale Variablen. Was allerdings nicht korrekt im Referenz-Artikel geschrieben steht (Punkt 21), ist, dass globale Variablen um den Faktor 2 langsamer als lokale Variablen sind. Das Gegenteil ist der Fall. Im Schnitt ist der Zugriff auf eine globale Variable schneller als der Zugriff auf eine lokale Variable - siehe auch die Ergebnisse.

Ergebnis
--------

siehe [data.md](data.md)

Fazit
-----

Der Zugriff auf entweder Mitgliedsvariablen oder lokale sowie globale Variablen dürfte sich in Gesamtlaufzeit die Waage halten - die Messungen zeigen einen marginalen Unterschied. Wer tatsächlich Wert darauf legt, das letzte aus den Script herauszukitzeln, hat immer noch die Möglichkeit, eine lokale Variable zum Inkrementieren zu verwenden und nachdem alle Inkrementierungen stattgefunden haben, das Ergebnis einer Mitgliedsvariablen zuzuweisen.