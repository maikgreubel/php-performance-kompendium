---
8. Benutze volle Pfade bei include oder require
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

/* Funktion zum erstellen von temporären Verzeichnissen */
function tempdir( $dir=false, $start_folder = null )
{
  if($start_folder === null)
	$start_folder = sys_get_temp_dir();

  $tempfile = tempnam( $start_folder, '' );
  if ( file_exists( $tempfile ) )
	unlink( $tempfile );
  mkdir( $tempfile );
  if ( is_dir( $tempfile ) )
	return $tempfile;
}

/* Erstelle benötigte Verzeichnisse */
$temp_dir_btest = tempdir(true, './');
$temp_dir_ctest = $temp_dir_btest . '/ctest';
$temp_dir_dtest = tempdir(true, './'); 

/* Erstelle Scripts, die includet werden sollen */
file_put_contents('dummy.php', $dummy_include);
file_put_contents('ATest.php', $class_file_1);
file_put_contents( $temp_dir_btest . '/BTest.php', $class_file_2);
mkdir($temp_dir_ctest);
file_put_contents( $temp_dir_btest . '/ctest/CTest.php', $class_file_3);
file_put_contents( $temp_dir_dtest . '/DTest.php', $class_file_4);

/* Damit das Ergebnis nicht durch Initialisierung verfälscht wird */
include('dummy.php');

/* Nehme diverse Verzeichnisse in den include_path auf */
set_include_path(get_include_path() . PATH_SEPARATOR .
  $temp_dir_btest . PATH_SEPARATOR .
  $temp_dir_dtest
);

/* Hier startet der Test */
$zeiten = array();

/* Die Geschäfs-Ausgaben interessieren uns hier nicht */
ob_start();

/* Test-Teil 1: include im aktuellen Verzeichnis ohne vollen Pfad */
$s = microtime(true);
include('ATest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit include() im aktuellen Verzeichnis ohne vollen Pfad: %1.8f\n", ($e-$s));

/* Test-Teil 2: include mit relativen vollen Pfad */
$s = microtime(true);
include($temp_dir_btest . '/BTest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit include() mit absoluten vollen Pfad: %1.8f\n", ($e-$s));

/* Test-Teil 3: include im Unterordner über include path */
$s = microtime(true);
include('ctest/CTest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit include() im Unterordner über include path: %1.8f\n", ($e-$s));

/* Test-Teil 4: require_once */
$s = microtime(true);
include('DTest.php');
$e = microtime(true);
$zeiten[] = sprintf("Zeit include() über include path: %1.8f\n", ($e-$s));

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();

/* Wieder aufräumen */
unlink('dummy.php');
unlink('ATest.php');
unlink($temp_dir_btest . '/BTest.php');
unlink($temp_dir_ctest . '/CTest.php');
unlink($temp_dir_dtest . '/DTest.php');
rmdir($temp_dir_dtest);
rmdir($temp_dir_ctest);
rmdir($temp_dir_btest);

/* Resultate anzeigen */
foreach($zeiten as $zeit) echo $zeit;
```

Kommentar
---------
Das verwenden von absoluten Pfaden sollte die schnellste Variante sein, um Dateien einzubinden. Denn dadurch wird der include_path umgangen und es muss von der Laufzeit nicht durch alle Pfade iteriert werden, die im include_path registriert sind.

Performance
-----------
Wie zu erwarten war, ist die Verwendung absoluter Pfade die performantestee Variante.

Ergebnis
--------

Der Test kann leider nicht in einer Schleife ausgeführt werden, da es sonst zu Fehlern wie "Klasse bereits deklariert" kommt.

siehe [data.md](data.md)

Fazit
-----
Wenn die einzubindenden Dateien im eigenen Applikations-Pfad liegen, ist die Verwendung von absoluten Pfaden problemlos möglich. Handelt es sich dagegen um Dritt-Anbieter-Scripte, die evtl. sogar in Libraries ausgelagert sind, ist das nicht immer so ohne weiteres möglich. Der include() über .phar-Files wurde überhaupt noch nicht in Augenschein genommen, dürfte aber noch langsamer sein, als über den include_path.