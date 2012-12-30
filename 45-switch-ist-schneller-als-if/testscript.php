<?php
$var		= "WE HAVE TO TEST IT";
$counter	= 500;
$times		= array();
for($i = 0; $i <= $counter; $i++)
{
	$s				= microtime(true);
	if($var == "We have to test iT")
	{
		$result = 'a';
	}
	elseif($var == "we have to test it")
	{
		$result = 'b';
	}
	elseif($var = 'We have To Test it')
	{
		$result = 'c';
	}
	elseif($var = 'We Have To Test It')
	{
		$result = 'd';
	}
	elseif($var = 'WE HAVE TO TEST IT')
	{
		$result = 'e';
	}
	else
	{
		$result = 'We have no Result';
	}

	$e				= microtime(true);

	$times[$i]['if_diff']	= sprintf("%1.8f", $e - $s);


	$s				= microtime(true);
	switch($var)
	{
		case "We have to test iT":
			$result = 'a';
			break;
		case "we have to test it":
			$result = 'b';
			break;
		case "We have To Test it":
			$result = 'c';
			break;
		case "We Have To Test It":
			$result = 'd';
			break;
		case "WE HAVE TO TEST IT":
			$result = 'e';
			break;
		default:
			$result = 'We have no Result';
			break;
	}
	$e				= microtime(true);

	$times[$i]['switch_diff']	= sprintf("%1.8f", $e - $s);
	$times[$i]['diff']				= sprintf("%1.8f", $times[$i]['if_diff'] - $times[$i]['switch_diff']);
}
