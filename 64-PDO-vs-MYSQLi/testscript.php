<?php
// Random Data
function random($laenge)
{
	$inhalt='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$string = "";
	srand(microtime()*1000000);
	
	for($i=1;$i<=$laenge;$i++)
	{
		$index	= rand(1,strlen($inhalt));
		$index--;
		$string	.= $inhalt{$index};
	}
	
	return $string;
}
// Vorbereitungen für den Test
$db = new PDO("mysql:host=localhost;port=3306","root");
$db->exec("Create Database `PHP-Performance-Kompendium` IF NOT EXISTS; ");
$db->exec("USE `PHP-Performance-Kompendium`;");

$db->exec("Drop Table `Test-PDO` IF EXISTS");
$db->exec("Drop Table `Test-MYSQLI` IF EXISTS");

$db->exec("Create Table `Test-PDO` (ID INT(11),DATA Varchar(255));");
$db->exec("Create Table `Test-MYSQLI` (ID INT(11),DATA Varchar(255));");
unset($db);

// neue Datenbankobjekte erzeugen
$pdo	= new PDO("mysql:host=localhost;port=3306;dbname=PHP-Performance-Kompendium","root");
$mysqli	= new mysqli("localhost","root",NULL,"PHP-Performance-Kompendium",3306);
 
$times	= array();

for($i = 0; $i <= 500; $i++)
{
	$string		= random(255);
	
	$s			= microtime(true);
	$pdo->query("Insert Into `Test-PDO`(`ID`,`DATA`) VALUES($i,'$string')");
	$e			= microtime(true);
	
	$times[$i]['PDO INSERT']		= sprintf("%1.8f",$e - $s);
	
	$s 			= microtime(true);
	$mysqli->query("Insert Into `Test-MYSQLI`(`ID`,`DATA`) VALUES($i,'$string')");
	$e			= microtime(true);
	
	$times[$i]['MYSQLI INSERT']	= sprintf("%1.8f",$e - $s);
	
	$s 			= microtime(true);
	$pdo->query("Select * From `Test-PDO` where ID=$i");
	$e			= microtime(true);
	
	$times[$i]['PDO SELECT'] = 	sprintf("%1.8f",$e - $s);
	
	$s			= microtime(true);
	$mysqli->query("Select * From `Test-MYSQLI` where ID=$i");
	$e			= microtime(true);
	
	$times[$i]['MYSQLI SELECT'] = sprintf("%1.8f",$e - $s);
	
	$s			= microtime(true);
	$pdo->query("Update `Test-PDO` set DATA='$string' where ID = $i");
	$e			= microtime(true);
	
	$times[$i]['PDO UPDATE'] = sprintf("%1.8f",$e - $s);
	
	$s			= microtime(true);
	$mysqli->query("Update `Test-MYSQLI` set DATA='$string' where ID = $i");
	$e			= microtime(true);
	
	$times[$i]['MYSQLI UPDATE'] = sprintf("%1.8f",$e - $s);
}
?>