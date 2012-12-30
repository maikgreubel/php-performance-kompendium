<?php
$times	= array();
for($i = 0; $i <= 500; $i++)
{
	ob_start();
	$s	= microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.\n";
	$e	= microtime(true);
	ob_end_flush();

	$times[$i]['ob_start'] = sprintf("%1.8f", $e - $s);

	$s = microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.\n";
	$e = microtime(true);

	$times[$i]['no_cache']		= sprintf("%1.8f", $e - $s);
	$times[$i]['difference']	= sprintf("%1.8f", $times[$i]['ob_start'] - $times[$i]['no_cache']);
}
