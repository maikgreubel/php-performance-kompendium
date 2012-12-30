<?php
$dummy_include = <<< EOT
<?php
function foo_6_3()
{
	echo 'bar';
}
EOT;

$class_file_1 = <<< EOT
<?php
class ATest_6_3
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
class BTest_6_3 extends ATest_6_3
{
	public function __construct()
	{
		\$this->_aVar = ' Welt';
	}
}
EOT;

$class_file_3 = <<< EOT
<?php
class CTest_6_3
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
class DTest_6_3 extends CTest_6_3
{
	public function __construct()
	{
		\$this->_cVar = ' Welt';
	}
}
EOT;

file_put_contents('dummy.php', $dummy_include);
file_put_contents('ATest_6_3.php', $class_file_1);
file_put_contents('BTest_6_3.php', $class_file_2);
file_put_contents('CTest_6_3.php', $class_file_3);
file_put_contents('DTest_6_3.php', $class_file_4);

/* Include-Path */
set_include_path(
	get_include_path() . PATH_SEPARATOR .
	dirname(__FILE__)
);

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

include('ATest_6_3.php');
$AObject = new ATest_6_3();
echo $AObject->getAVar();

include('BTest_6_3.php');
$BObjekt = new BTest_6_3();
echo $BObjekt->getAVar();

$e = microtime(true);
$zeiten[0]['explicit_include'] = sprintf("%1.8f", ($e-$s));

/* Test-Teil 2: Klassen-Include über __autoload() */
$s = microtime(true);

$CObject = new CTest_6_3();
echo $CObject->getCVar();

$DObject = new DTest_6_3();
echo $DObject->getCVar();

$e = microtime(true);
$zeiten[0]['autoload'] = sprintf("%1.8f", ($e-$s));

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();

/* Wieder aufräumen */
unlink('dummy.php');
unlink('ATest_6_3.php');
unlink('BTest_6_3.php');
unlink('CTest_6_3.php');
unlink('DTest_6_3.php');

