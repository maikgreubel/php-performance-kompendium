<?php
/**
 * Class for displaying colors in console.
 * 
 * @author https://gist.github.com/1315354
 */
class ColorCLI
{
	static $foreground_colors = array(
			'black'        => '0;30', 'dark_gray'    => '1;30',
			'blue'         => '0;34', 'light_blue'   => '1;34',
			'green'        => '0;32', 'light_green'  => '1;32',
			'cyan'         => '0;36', 'light_cyan'   => '1;36',
			'red'          => '0;31', 'light_red'    => '1;31',
			'purple'       => '0;35', 'light_purple' => '1;35',
			'brown'        => '0;33', 'yellow'			 => '1;33',
			'light_gray'   => '0;37', 'white'        => '1;37',
	);

	static $background_colors = array(
			'black'        => '40', 'red'          => '41',
			'green'        => '42', 'yellow'       => '43',
			'blue'         => '44', 'magenta'      => '45',
			'cyan'         => '46', 'light_gray'   => '47',
	);
	
	/**
	 *  Returns colored string
	 *  
	 *  In case of we are on windows, we need to modify it
	 *  a little bit to make use of ansicon tool.
	 *  
	 *  @param $string The to make colored
	 *  @param $foreground_color The to use (@see $foreground_colors)
	 *  @param $background_color The to use (@see $background_colors)
	 *  
	 *  @return Colored string either bash or ansicon compatible
	 */
	public static function getColoredString($string, $foreground_color = null, $background_color = null)
	{
		$esc = chr(27);
		$colored_string = "";

		// Check if given foreground color found
		if ( isset(self::$foreground_colors[$foreground_color]) )
		{
			if(stristr(PHP_OS, 'win'))
				$colored_string .= sprintf("%s[%s", $esc, self::$foreground_colors[$foreground_color]);
			else
				$colored_string .= sprintf("%s[%sm", $esc, self::$foreground_colors[$foreground_color]);
		}
		// Check if given background color found
		if ( isset(self::$background_colors[$background_color]) ) {
			if(stristr(PHP_OS, 'win'))
				$colored_string .= sprintf(";%sm", self::$background_colors[$background_color]);
			else
				$colored_string .= sprintf("%s[%sm", $esc, self::$background_colors[$background_color]);
		}

		// Add string and end coloring
		$colored_string .=  sprintf("%s%s[0m", $string, $esc);

		return $colored_string;
	}
	
	/**
	 * Returns all foreground color names
	 * @return multitype:
	 */
	public static function getForegroundColors()
	{
		return array_keys(self::$foreground_colors);
	}

	/**
	 * Returns all background color names
	 * @return multitype:
	 */
	public static function getBackgroundColors()
	{
		return array_keys(self::$background_colors);
	}
}