<?php
$dummy_include = <<< EOT
<?php
function foo_7()
{
	echo 'bar';
}
EOT;

$class_file_1 = <<< EOT
<?php
class ATest_7
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
class BTest_7
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
class CTest_7
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
class DTest_7
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
$zeiten[0]['explicit require_once'] = sprintf("%1.8f", ($e-$s));

/* Test-Teil 2: require */
$s = microtime(true);
require('BTest.php');
$e = microtime(true);
$zeiten[0]['explicit require'] = sprintf("%1.8f", ($e-$s));

/* Test-Teil 3: include_once */
$s = microtime(true);
include_once('CTest.php');
$e = microtime(true);
$zeiten[0]['explicit include'] = sprintf("%1.8f", ($e-$s));

/* Test-Teil 4: include */
$s = microtime(true);
include('DTest.php');
$e = microtime(true);
$zeiten[0]['explicit include'] = sprintf("%1.8f", ($e-$s));

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();

/* Wieder aufräumen */
unlink('dummy.php');
unlink('ATest.php');
unlink('BTest.php');
unlink('CTest.php');
unlink('DTest.php');
