---
6. Vermeide magische Methoden wie __get
---

Beispiel
--------
```php
<?php
/**
 * Klasse zum testen von magischen und dedizierten Gettern
 */
class Gettest
{
  /**
   * Eine Mitgliedsvariable
   * @access private
   */
  private $_a;

  /**
   * Konstruktor, der die lokale Mitgliedsvariable mit einem zufälligen Ganzzahl-Wert versorgt
   */
  public function __construct()
  {
	$this->_a = mt_rand(1, 10000);
  }

  /**
   * Magische Get-Methode
   * @param name Der Name der Mitgliedsvariable, deren Wert abgeholt werden soll
   */
  public function __get($name)
  {
	if(!property_exists(get_called_class(), $name))
		throw new Exception("Property '$name' does not exist");
	return $this->$name;
  }

  /**
   * Dedizierte Get-Methode für die Mitgliedsvariable
   */
  public function getA()
  {
	return $this->_a;
  }
}

$zeiten = array();

/* Die Geschäfs-Ausgaben interessieren uns hier nicht */
ob_start();

/* Wir testen den gleichen Ablauf 10 mal */
for($i = 0; $i < 10; $i++)
{
  $objekt = new Gettest();

  /* Test-Teil 1: Zugriff auf Gettest::_a über magische Methode */
  $s = microtime(true);
  echo $objekt->_a;
  $e = microtime(true);
  $zeiten[] = sprintf("Zeit Zugriff über magische Methode __get: %1.8f\n", ($e-$s));

  /* Test-Teil 2: Zugriff auf Gettest::_a über dedizierte Methode */
  $s = microtime(true);
  echo $objekt->getA();
  $e = microtime(true);
  $zeiten[] = sprintf("Zeit Zugriff über Getter-Methode: %1.8f\n", ($e-$s));
}

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();

/* Resultate anzeigen */
foreach($zeiten as $zeit) echo $zeit;
```

Kommentar
---------

Innerhalb der magischen Methode __get() können die Zugriffe auf die lokalen Klassen-Mitgliedsvariablen geregelt werden, ohne das für jede einzelne Mitgliedsvariable eine eigene Get-Methode geschrieben werden muss.

Performance
-----------

Auch wenn wir den ersten Lauf als Ausreiser vernachlässigen (dem Caching geschuldet), ist der Zugriff über die magische get()-Methode tatsächlich etwas langsamer. Wenn man jetzt noch Business-Code dazu denkt, der Zugriffssteuerung übernimmt - um das gleiche Verhalten wie eine dedizierte Get-Methode für Gettest::_a zu simulieren, wird die tatsächliche Laufzeit nochmals erhöht.

Ergebnis
--------
	Zeit Zugriff über magische Methode __get: 0.00003600
	Zeit Zugriff über Getter-Methode: 0.00001287
	Zeit Zugriff über magische Methode __get: 0.00000691
	Zeit Zugriff über Getter-Methode: 0.00000286
	Zeit Zugriff über magische Methode __get: 0.00000596
	Zeit Zugriff über Getter-Methode: 0.00000191
	Zeit Zugriff über magische Methode __get: 0.00000620
	Zeit Zugriff über Getter-Methode: 0.00000215
	Zeit Zugriff über magische Methode __get: 0.00000501
	Zeit Zugriff über Getter-Methode: 0.00000310
	Zeit Zugriff über magische Methode __get: 0.00000596
	Zeit Zugriff über Getter-Methode: 0.00003195
	Zeit Zugriff über magische Methode __get: 0.00000620
	Zeit Zugriff über Getter-Methode: 0.00000310
	Zeit Zugriff über magische Methode __get: 0.00000596
	Zeit Zugriff über Getter-Methode: 0.00000310
	Zeit Zugriff über magische Methode __get: 0.00000596
	Zeit Zugriff über Getter-Methode: 0.00000215
	Zeit Zugriff über magische Methode __get: 0.00000596
	Zeit Zugriff über Getter-Methode: 0.00000191


Fazit
-----
Auch wenn es mehr Code bedeutet, ist eine dedizierte Get-Methode für Klassen-Mitgliedsvariablen die perfomantere Variante. Zu Aspekten der Leserlichkeit des Codes ist sind dedizierte Get-Methoden auf jeden Fall vorzuziehen.