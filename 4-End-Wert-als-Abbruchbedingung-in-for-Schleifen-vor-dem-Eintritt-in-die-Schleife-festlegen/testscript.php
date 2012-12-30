<?php
// Bitte die erste for-Schleife ignorieren, nur für die Vorbereitung des Tests notwendig
$testdata = array();
for($i = 0; $i < 10000; $i++)
{
	$testdata[] = $i * 31 ^ ($i-1);
}

// Hier startet der Test
$zeiten = array();
$t = 0;
$s = microtime(true);
for($n = 0; $n < count($testdata); $n++)
{
	$t = $t + $testdata[$n];
}
$e = microtime(true);
$zeiten[0]['count'] = sprintf("%1.8f", ($e-$s));

$t = 0;
$s = microtime(true);
for($n = 0, $k = count($testdata); $n < $k; $n++)
{
	$t = $t + $testdata[$n];
}
$e = microtime(true);
$zeiten[0]['fixed'] = sprintf("%1.8f", ($e-$s));
$zeiten[0]['diff'] = sprintf("%1.8f", ($zeiten[0]['count'] - $zeiten[0]['fixed']));
