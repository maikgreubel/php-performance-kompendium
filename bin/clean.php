<?php
/**
 * Some basic settings
**/
define('BIN_FOLDER', dirname(__FILE__));
define('TOP_FOLDER', realpath( BIN_FOLDER . '/..'));

/**
 * Needed classes and utils
**/
require( BIN_FOLDER . '/functions.php' );

run( 'clean' );
