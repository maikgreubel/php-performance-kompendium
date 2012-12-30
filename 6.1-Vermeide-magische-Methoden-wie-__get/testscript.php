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
	$zeiten[0]['magic_get'] = sprintf("%1.8f", ($e-$s));

	/* Test-Teil 2: Zugriff auf Gettest::_a über dedizierte Methode */
	$s = microtime(true);
	echo $objekt->getA();
	$e = microtime(true);
	$zeiten[0]['getter']= sprintf("%1.8f", ($e-$s));
}

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();
