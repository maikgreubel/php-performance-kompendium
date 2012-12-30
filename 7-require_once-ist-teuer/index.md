---
7. require_once ist teuer
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
class BTest
{
	protected \$_bVar;

	public function __construct()
	{
		\$this->_bVar = 'Welt';
	}

	public function getBVar()
	{
		return \$this->_bVar;
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
class DTest
{
	protected \$_dVar;

	public function __construct()
	{
		\$this->_dVar = 'Hallo';
	}

	public function getDVar()
	{
		return \$this->_dVar;
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

/* Test-Teil 1: require_once */
$s = microtime(true);
require_once('ATest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit expliziter require_once(): %1.8f\n", ($e-$s));

/* Test-Teil 2: require */
$s = microtime(true);
require('BTest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit expliziter require(): %1.8f\n", ($e-$s));

/* Test-Teil 3: include_once */
$s = microtime(true);
include_once('CTest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit expliziter include_once(): %1.8f\n", ($e-$s));

/* Test-Teil 1: require_once */
$s = microtime(true);
include('DTest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit expliziter include(): %1.8f\n", ($e-$s));

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

require, require\_once, sowie include und include\_once binden zusätzliche Dateien ein. require\_once und require werfen einen Fehler ist, wenn die Dateien, die eingebunden werden sollen, nicht gefunden werden können oder ein Zugriff anderweitig nicht möglich ist. Alle vier Varianten machen Gebrauch des sog. include\_path, welcher über php.ini (permanent) oder set\_include_path (nur für aktuelle Sitzung) festgelegt wird.

Performance
-----------

Hier können keine Tests in einer Schleife laufen gelassen werden. Es liegt in der Natur der Sache, dass die _once()-Versionen langsamer sind, denn sie prüfen vor dem Einbinden, ob dies bereits erledigt wurde und würden in diesem Fall den zweiten Versuch ignorieren. Das die require-Version langsamer ist, als die include-Version ist auch verständlich, denn es müssen vor dem Öffnen der Dateien geprüft werden, ob dies überhaupt erfolgreich sein wird (existiert die Datei, stimmen die Rechte).

Von "teuer" kann allerdings nicht die Rede sein.

Ergebnis
--------

siehe [data.md](data.md)

Fazit
-----
Man sollte sich eher Gedanken machen, ob man die once()-Methode verwendet. Natürlich kann man __autoload() verwenden, und so auf die once()-Variante verzichten.