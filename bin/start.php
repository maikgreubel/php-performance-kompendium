<?php
/**
 * Some basic settings
 **/
define('BIN_FOLDER', dirname(__FILE__));
define('TOP_FOLDER', realpath( BIN_FOLDER . '/..'));

/**
 * Needed classes and utils
 **/
require(BIN_FOLDER . '/classes/ColorCLI.php');
require(BIN_FOLDER . '/classes/Markdown.php');

/**
 * Perform a single test script and return result
 * 
 * @param $file The to test
 * @param $cli The instance to make colored output
 **/
function perform_test($file, ColorCLI $cli)
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
	include_once($file);
	if(!isset($zeiten))
	{
		return -1;
	}
	$markdown->setData($zeiten);
	$markdown->setTitle($title);
	$markdown->setDescription($description);
	
	$markdown->write();
	
	return 0;
}

function run()
{
	$cc = new ColorCLI();
	
	echo "Using top level folder " . $cc->getColoredString(TOP_FOLDER, 'green', 'black') . "\n";
	echo "Using bin folder " .$cc->getColoredString(BIN_FOLDER, 'green', 'black') . "\n";
	
	$dirs = opendir(TOP_FOLDER);
	
	$subfolders = array();
	while($fileinfo = readdir())
	{
		$abspath = realpath(TOP_FOLDER . '/' . $fileinfo);
		if( is_dir($abspath) &&
				preg_match('/^([0-9]{1,})-.*/', $fileinfo, $match) )
		{
			$index = $match[1];
			$subfolders[$index] = $abspath;
		}
	}
	closedir($dirs);
	ksort($subfolders);
	
	foreach($subfolders as $testcase)
	{
		$script_file = $testcase . '/testscript.php';
		
		switch(perform_test($script_file, $cc))
		{
			case 0:
				echo $cc->getColoredString('Success  ', 'light_green', 'black') . basename($testcase) . "\n";
				break;
				
			case -1:
				echo $cc->getColoredString('Failure  ', 'red', 'black') . basename($testcase) . " (has no result!)\n";
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

run();
