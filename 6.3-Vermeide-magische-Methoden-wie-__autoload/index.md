---
6. Vermeide magische Methoden wie __autoload
---

Beispiel
--------
```php
<?php
$dummy_include = <<< EOT
<?php
function foo()
{
	echo 'bar';
}
EOT;

$class_file_1 = <<< EOT
<?php
class ATest
{
	protected \$_aVar;

	public function __construct()
	{
		\$this->_aVar = 'Hallo';
	}

	public function getAVar()
	{
		return \$this->_aVar;
	}
}
EOT;

$class_file_2 = <<< EOT
<?php
class BTest extends ATest
{
	public function __construct()
	{
		\$this->_aVar = ' Welt';
	}
}
EOT;

$class_file_3 = <<< EOT
<?php
class CTest
{
	protected \$_cVar;

	public function __construct()
	{
		\$this->_cVar = 'Hallo';
	}

	public function getCVar()
	{
		return \$this->_cVar;
	}
}
EOT;

$class_file_4 = <<< EOT
<?php
class DTest extends CTest
{
	public function __construct()
	{
		\$this->_cVar = ' Welt';
	}
}
EOT;

file_put_contents('dummy.php', $dummy_include);
file_put_contents('ATest.php', $class_file_1);
file_put_contents('BTest.php', $class_file_2);
file_put_contents('CTest.php', $class_file_3);
file_put_contents('DTest.php', $class_file_4);

/* Damit das Ergebnis nicht durch Initialisierung verfälscht wird */
include('dummy.php');

function __autoload($class)
{
	include($class . '.php');
}

/* Hier startet der Test */
$zeiten = array();

/* Die Geschäfs-Ausgaben interessieren uns hier nicht */
ob_start();

/* Test-Teil 1: Manueller include() der benötigten Klassen */
$s = microtime(true);

include('ATest.php');
$AObject = new ATest();
echo $AObject->getAVar();

include('BTest.php');
$BObjekt = new BTest();
echo $BObjekt->getAVar();

$e = microtime(true);
$zeiten[] = sprintf("Zeit expliziter include(): %1.8f\n", ($e-$s));

/* Test-Teil 2: Klassen-Include über __autoload() */
$s = microtime(true);

$CObject = new CTest();
echo $CObject->getCVar();

$DObject = new DTest();
echo $DObject->getCVar();

$e = microtime(true);
$zeiten[] = sprintf("Zeit mit __autoload(): %1.8f\n", ($e-$s));

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();

/* Wieder aufräumen */
unlink('dummy.php');
unlink('ATest.php');
unlink('BTest.php');
unlink('CTest.php');
unlink('DTest.php');

/* Resultate anzeigen */
foreach($zeiten as $zeit) echo $zeit;
```

Kommentar
---------
__autoload() ist die Möglichkeit, Klassen-Dateien zu automatisch bei Gebrauch inkludieren zu lassen. Programmierer, die kein Autoloading verwenden, müssen die einzubindenen Klassen manuell bzw. explizit über include() oder require() einbinden. Häufig wird dann im Quelltext zu viel eingebunden, und somit Rechenzeit verbraucht, obwohl es gar nicht notwendig ist. Mit Autoload() wird automatisch ein include() versucht, wenn die Klasse noch nicht in der Laufzeit bekannt ist. Das heißt, es kann nicht vorkommen, das eine Klasse mehr als einmal oder unnötigerweise geladen wird.

Performance
-----------
Man könnte meinen, dass ein Feature wie Autoloading zwangsläufig mehr Performance kostet als ein manueller, expliziter include(). Dem ist aber nicht so, wie die Ergebnisse zeigen. Der Grund könnte darin liegen, dass hier mit abgeleiteten Klassen getestet wurde (was wohl näher an der Realität liegen dürfte, vor allem, wenn man Frameworks einsetzt), anstatt loser Einzelklassen ohne Vererbung.

Ergebnis
--------

siehe [data.md](data.md)

Der Test kann leider nicht in einer Schleife ausgeführt werden, da es sonst zu Fehlern wie "Klasse bereits deklariert" kommt. Daher wurde der Test mehrere Male manuell hintereinander ausgeführt. Immer war __autoload() schneller. Der hier im Ergebnis notierte Wert ist der schnelleste für den expliziten include().

Fazit
-----
Bei der Aussage, das Autoloading langsamer ist als epliziter include() handelt es sich zu mindest teilweise um einen Irrtum. Bei Klassen, die abgeleitet sind, kann __autoload() schneller sein, als ein expliziter include. Der Grund dafür liegt evtl. in der Funktion zend_fetch_class() in der Zend/zend_execute_API.c des PHP-Sourcecodes.