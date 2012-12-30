<?php
/**
* Autor: Leon Bergmann
* Datum: 24.12.2012 12:50
* Update: 25.12.2012 01:34 Uhr 
* License: BSD (see https://github.com/skydevment/php-performance-tool/blob/master/LICENSE.md)
* markdown class.
*/
class Markdown
{
	/**
	 * filename
	 * 
	 * (default value: "data.md")
	 * 
	 * @var string
	 */
	private $filename;
	/**
	 * average
	 * 
	 * @var mixed
	 * @access private
	 */
	private $average;
	/**
	 * max
	 * 
	 * @var mixed
	 * @access private
	 */
	private $max;
	/**
	 * min
	 * 
	 * @var mixed
	 * @access private
	 */
	private $min;
	/**
	 * count
	 * 
	 * @var mixed
	 * @access private
	 */
	private $count;
	/**
	 * data
	 * 
	 * @var mixed
	 * @access private
	 */
	private $data;
	/**
	 * title
	 * 
	 * @var mixed
	 * @access private
	 */
	private $title;
	/**
	 * description
	 * 
	 * @var mixed
	 * @access private
	 */
	private $description; 

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @param mixed $title (default: null)
	 * @param mixed $description (default: null)
	 * @return void
	 */
	public function __construct($data = null, $title = null, $description = null)
	{
		$this->filename = dirname(__FILE__) ." /data.md";
		$this->data		= $data;
		$this->title	= $title;
	}

	/**
	 * Set the data values
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data		= $data;
	}
	
	/**
	 * Set the title
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = strval($title);
	}
	
	/**
	 * Set the description
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = strval($description);
	}

	/**
	 * write function.
	 * 
	 * @access public
	 * @return void
	 */
	public function write()
	{
		$this->statistics();
		$fileContent[] 	= $this->markdownFileHead();
		$fileContent[]	= $this->markdownDataHeader();
		$fileContent[]	= $this->markdownData();
		$fileContent[]	= $this->markdownStatistic();
		
		$fileContent	= implode("\n", $fileContent);
		
		//chdir(dirname(__FILE__));
		file_put_contents($this->filename, $fileContent);
	}
	
	public function setDataDir($dir)
	{
		$this->setDataPathAbsolute($dir . '/data.md');
	}
	
	public function setDataPathAbsolute($path)
	{
		if(!is_dir(dirname($path)))
			throw new Exception("Directory " . dirname($path) . " does not exist!");
		$this->filename =  $path;
	}
	
	/**
	 * markdownFileHead function.
	 * 
	 * @access private
	 * @return string
	 */
	private function markdownFileHead()
	{
		
		if(!is_null($this->title))
		{
			$head	= '---------'."\n";
			$head  .= '# $this->title';
			$head  .= '---------'."\n";
		}
		else
		{
			$head	= '---------'."\n";
			$head  .= '# Data'."\n";
			$head  .= '---------'."\n";
		}
		if(!is_null($this->description))
		{
			$head = $this->description."\n";
		}
		
		return $head;
	}
	

	/**
	 * markdownData function.
	 * 
	 * @access private
	 * @return string
	 */
	private function markdownData()
	{
		$fileContent[] = '```'."\n";
		$i = 1;
		foreach($this->data as $localData)
		{
			$fileContent[$i] = $i." | ";
			$fileContent[$i] .= implode(" | ", $localData);
			$fileContent[$i] .= "\n";
			++$i;
		}
		$fileContent[] = '```'."\n";
		$result		   = implode($fileContent);
		
		unset($fileContent,$i);
		
		return $result;
	}
	/**
	 * markdownDataHeader function.
	 * 
	 * @access private
	 * @return string
	 */
	private function markdownDataHeader()
	{
		$keys  = array_keys($this->data[0]);
		$keys  = "## Anzahl | ".implode(" | ", $keys)."\n";
		return $keys;
	}
	/**
	 * markdownStatistic function.
	 * 
	 * @access private
	 * @return string
	 */
	private function markdownStatistic()
	{
		$footer		= '## Statistik'."\n";
		
		$minKeys	= array_keys($this->min);
		$maxKeys	= array_keys($this->max);
		$aveKeys	= array_keys($this->average);
		
		$minKeys	= implode(" | ", $minKeys);
		$maxKeys	= implode(" | ", $maxKeys);
		$aveKeys	= implode(" | ", $aveKeys);
		
		$minData	= implode(" | ", $this->min);
		$maxData	= implode(" | ", $this->max);
		$aveData	= implode(" | ", $this->average);
		
		$footer	   .= '### min values'."\n".'#### '.$minKeys."\n".'```'."\n".$minData."\n".'```'."\n";
		$footer	   .= '### max values'."\n".'#### '.$maxKeys."\n".'```'."\n".$maxData."\n".'```'."\n";
		$footer	   .= '### average values'."\n".'#### '.$aveKeys."\n".'```'."\n".$aveData."\n".'```'." \n ";
		
		return $footer;	
	}

	
	/**
	 * statistics function.
	 * 
	 * @access private
	 * @return void
	 */
	private function statistics()
	{
		$sortedArray	= $this->statisticsArraySort();
		
		$this->count	= count($this->data);
		$this->max		= $this->getMinMax($sortedArray,true);
		$this->min		= $this->getMinMax($sortedArray);
		$this->average	= $this->getAverage($sortedArray);
	
	}
	
	/**
	 * statisticsArraySort function.
	 * 
	 * @access private
	 * @return array
	 */
	private function statisticsArraySort()
	{
		$tmp = array();
		for($i = 0; $i < count($this->data); $i++)
		{
			if(!isset($this->data[$i]))
				throw new Exception("Internal statistics error: Index $i does not exists in data array");
			
			foreach($this->data[$i] as $key=>$element)
			{
				$tmp[$key][] = $element;
			}
		}
		
		foreach($tmp as $key=>$sub)
		{
			$tmps = $sub;
			sort($tmps);
			unset($tmp[$key]);
			$tmp[$key] = $tmps;
			unset($tmps);
			
		}
		
		return $tmp;
	}

	
	/**
	 * getAverage function.
	 * 
	 * @access private
	 * @param mixed $tmp
	 * @return array
	 */
	private function getAverage($tmp)
	{
		$result = array();
		$local	= (int)0;
		foreach($tmp as $key=>$element)
		{
			foreach($element as $a)
			{
				if(!is_numeric($a))
				{
					throw new Exception("Value ".(is_array($a) ? "'Array'" : $a)." is not a number!");
				}
				$local  += $a;
			}
			$local = ($local / $this->count);
			$result[$key] = $local;
		}
		
		return $result;
	}
	
		
	/**
	 * getMinMax function.
	 * 
	 * @access private
	 * @param bool $max (default: false)
	 * @return array
	 */
	private function getMinMax($tmp,$max = false)
	{
		$result = array();
		if($max)
		{
			foreach($tmp as $key=>$local)
			{
				if(isset($local[($this->count - 1)]))
					$result[$key] = $local[($this->count - 1)];
				else
					throw new Exception(" Index " . $this->count - 1 ." Does not exist in local data array");
			}
		}
		else
		{
			foreach($tmp as $key=>$local)
			{
				 $result[$key] = $local[0];
			}

		}
		unset($tmp);
		return $result;
	}
	
	/**
	 * Return the last modification time of data file
	 * @return integer The timestamp of last modification
	 */
	public function lastModified()
	{
		if(file_exists($this->filename) && ($stats = stat($this->filename)) != FALSE)
		{
			return intval($stats['mtime']);
		}
		else
		{
			return 0;
		}
	}
	
	public function clean()
	{
		if(file_exists($this->filename))
			return unlink($this->filename);
		
		return 1;
	}
}
?>
