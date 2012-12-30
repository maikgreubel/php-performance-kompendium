---
6. Vermeide magische Methoden wie __set
---

Beispiel
--------
```php
<?php
/**
 * Klasse zum testen von magischen und dedizierten Settern
 */
class Settest
{
	/**
	 * Eine Mitgliedsvariable
	 * @access private
	 */
	private $_a;

	/**
	 * Magische Set-Methode
	 * @param name Der Name der Mitgliedsvariable, deren Wert überschrieben werden soll
	 */
	public function __set($name, $value)
	{
		if(!property_exists(get_called_class(), $name))
			throw new Exception("Property '$name' does not exist");
		$this->$name = $value;
	}

	/**
	 * Dedizierte Set-Methode für die Mitgliedsvariable
	 */
	public function setA($value)
	{
		$this->_a = $value;
	}
}

$zeiten = array();

/* Wir testen den gleichen Ablauf 10 mal */
for($i = 0; $i < 10; $i++)
{
	$objekt = new Settest();

	$a = mt_rand(1, 10000);

	/* Test-Teil 1: Zugriff auf Settest::_a über magische Methode */
	$s = microtime(true);
	$objekt->_a = $a;
	$e = microtime(true);
	$zeiten[] = sprintf("Zeit Zugriff über magische Methode __set: %1.8f\n", ($e-$s));

	/* Test-Teil 2: Zugriff auf Settest::_a über dedizierte Methode */
	$s = microtime(true);
	$objekt->setA($a);
	$e = microtime(true);
	$zeiten[] = sprintf("Zeit Zugriff über Setter-Methode: %1.8f\n", ($e-$s));
}

/* Resultate anzeigen */
foreach($zeiten as $zeit) echo $zeit;
```

Kommentar
---------

Innerhalb der magischen Methode __set() können die Zugriffe auf die lokalen Klassen-Mitgliedsvariablen geregelt werden, ohne das für jede einzelne Mitgliedsvariable eine eigene Set-Methode geschrieben werden muss.

Performance
-----------

Auch wenn wir den ersten Lauf als Ausreiser vernachlässigen (dem Caching geschuldet), ist der Zugriff über die magische set()-Methode tatsächlich etwas langsamer. Man könnte in der magischen __set()-Methode die Prüfung auf die Existenz der lokalen Mitgliedsvariablen weg lassen und würde dennoch langsamer sein.

Ergebnis
--------

siehe [data.md](data.md)

Fazit
-----
Wie bei Gettest ist eine dedizierte Set-Methode für Klassen-Mitgliedsvariablen die perfomantere Variante. Zu Aspekten der Leserlichkeit des Codes ist sind dedizierte Set-Methoden auf jeden Fall vorzuziehen.