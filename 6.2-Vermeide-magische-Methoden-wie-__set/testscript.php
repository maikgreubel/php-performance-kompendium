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
	$zeiten[0]['magic_set'] = sprintf("%1.8f", ($e-$s));

	/* Test-Teil 2: Zugriff auf Settest::_a über dedizierte Methode */
	$s = microtime(true);
	$objekt->setA($a);
	$e = microtime(true);
	$zeiten[0]['setter'] = sprintf("%1.8f", ($e-$s));
}

