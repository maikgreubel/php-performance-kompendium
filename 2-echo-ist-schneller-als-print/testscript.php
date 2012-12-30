<?php
$zeiten = array();
$count = 500;

// Output unterdrücken
//ob_start();
for($i = 0; $i <= $count; $i++)
{
	$s = microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.\n";
	$e = microtime(true);
	$zeiten[$i]['echo'] = sprintf("%1.8f", $e - $s);
	
	$s = microtime(true);
	print("Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.\n");
	$e = microtime(true);
	$zeiten[$i]['print'] = sprintf("%1.8f", $e - $s);
	
	$zeiten[$i]['diff'] = sprintf("%1.8f", $zeiten[$i]['echo'] - $zeiten[$i]['print']);
}
//ob_end_clean();