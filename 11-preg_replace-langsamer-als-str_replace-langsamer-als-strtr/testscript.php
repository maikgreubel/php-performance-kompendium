<?php
/* Hier startet der Test */
$zeiten = array();

$var = 'Hallo Welt';

/* Die Geschäfs-Ausgaben interessieren uns hier nicht */
ob_start();

for($i = 0; $i < 10; $i++)
{
	/* Test-Teil 1: preg_replace */
	$s = microtime(true);
	echo preg_replace('/a/', 'e', $var) . "\n";
	$e = microtime(true);
	$zeiten[$i]['preg_replace'] = sprintf("%1.8f", ($e-$s));

	/* Test-Teil 2: str_replace */
	$s = microtime(true);
	echo str_replace('a', 'e', $var) . "\n";
	$e = microtime(true);
	$zeiten[$i]['str_replace'] = sprintf("%1.8f", ($e-$s));

	/* Test-Teil 3: strtr */
	$s = microtime(true);
	echo strtr($var, 'a', 'e') . "\n";
	$e = microtime(true);
	$zeiten[$i]['strtr'] = sprintf("%1.8f", ($e-$s));
}

/* Wir verwerfen die Geschäftsausgabe */
ob_end_clean();
