<?php
function clean_test($file)
{
	$markdown = new Markdown();
	$markdown->setDataDir(dirname($file));
	return $markdown->clean();
}

/**
 * Perform a single test script and return result
 *
 * @param $file The to test
 * @param $cli The instance to make colored output
 **/
function perform_test($file, ColorCLI $cli, &$lastError = null)
{
	clearstatcache();

	if(!file_exists($file))
	{
		return 1;
	}

	$stats = stat($file);

	$title = null;
	$description = null;

	$markdown = new Markdown();
	$markdown->setDataDir(dirname($file));

	if($markdown->lastModified() >= $stats['mtime'])
	{
		return 2;
	}

	if(isset($zeiten))
		unset($zeiten);
	if(isset($times))
		unset($times);

	$current = getcwd();

	// We want the script to be executed in its own directory...
	chdir(dirname($file));
	include_once($file);
	chdir($current);

	if(!isset($zeiten) && !isset($times))
	{
		return -1;
	}
	if((isset($times) && count($times) > 0) &&
			(!isset($zeiten) || empty($zeiten)))
		$zeiten = $times;

	try {
		$markdown->setData($zeiten);
		$markdown->setTitle($title);
		$markdown->setDescription($description);

		$markdown->write();
	}
	catch(Exception $e)
	{
		if(isset($lastError))
			$lastError = $e->getMessage();
		return -1;
	}

	return 0;
}

function run($args = null)
{
	$cc = new ColorCLI();

	echo "Using top level folder " . $cc->getColoredString(TOP_FOLDER, 'green', 'black') . "\n";
	echo "Using bin folder " .$cc->getColoredString(BIN_FOLDER, 'green', 'black') . "\n";

	$dirs = opendir(TOP_FOLDER);

	$subfolders = array();
	while($fileinfo = readdir())
	{
		$abspath = realpath(TOP_FOLDER . '/' . $fileinfo);

		if( $fileinfo == '.' || $fileinfo == '..' ||
				$fileinfo == '.git' || $fileinfo == '.settings' ||
				$fileinfo == 'bin' || is_file($abspath) || is_link($abspath))
			continue;

		if(preg_match('/^([0-9\.]{1,}?)-.*/u', $fileinfo, $match) )
		{
			$index = $match[1];
			$subfolders[$index] = $abspath;
		}
		else
		{
			echo $cc->getColoredString('Skipping ', 'purple', 'black') . $fileinfo . " (no valid folder name)\n";
		}
	}
	closedir($dirs);
	ksort($subfolders);

	foreach($subfolders as $testcase)
	{
		$script_file = $testcase . '/testscript.php';
		$lastError = "";

		if($args == 'clean')
		{
			$rc = clean_test($script_file);
			if($rc == 1)
				echo $cc->getColoredString('Skipping ', 'yellow', 'black') . basename($testcase) . " (no data)\n";
			elseif($rc == true)
				echo $cc->getColoredString('Clean    ', 'light_green', 'black') . basename($testcase) . "\n";
			else
				echo $cc->getColoredString('Failure  ', 'light_red', 'black') . basename($testcase) . "\n";
				
			continue;
		}

		switch(perform_test($script_file, $cc, $lastError))
		{
			case 0:
				echo $cc->getColoredString('Success  ', 'light_green', 'black') . basename($testcase) . "\n";
				break;

			case -1:
				echo $cc->getColoredString('Failure  ', 'red', 'black') . basename($testcase) . " (".($lastError?$lastError:'has no result!').")\n";
				break;

			case 1:
				echo $cc->getColoredString('Skipping ', 'yellow', 'black') . basename($testcase) . " (no test script)\n";
				break;

			case 2:
				echo $cc->getColoredString('Skipping ', 'cyan', 'black') . basename($testcase) . " (not modified)\n";
				break;

			default:
				echo $cc->getColoredString('UNKNOWN  ', 'white', 'black') . basename($testcase) . "\n";
				break;
		}
	}
}