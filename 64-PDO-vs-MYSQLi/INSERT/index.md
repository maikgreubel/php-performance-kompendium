------
64. PDO vs. MYSQLi INSERT
------

Beispiel
--------
```php
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
	
	$times[$i]['PDO']		= sprintf("%1.8f",$e - $s);
	
	$s 			= microtime(true);
	$mysqli->query("Insert Into `Test-MYSQLI`(`ID`,`DATA`) VALUES($i,'$string')");
	$e			= microtime(true);
	
	$times[$i]['MYSQLI']	= sprintf("%1.8f",$e - $s);
}
?>
```
Kommentar
---------
Da PDO den wesentlich neueren Ansatz zum Zugriff auf Datenbanken darstellt würde ich PDO MYSQLi vorziehen. PDO ist komplett Objektorientiert, MYSQLi hingegen nur halb.
Ein weiterer Vorteil von PDO ist die Möglichkeit verschiedenen Datenbanktypen durch eine Klasse anzusprechen, da PDO eine Abstraktionsschicht für den Datenbankzugriff darstellt.
PDO stellt allerdings keine Abstraktionsschicht für die verschiedenen Eigenarten der Datenbanken dar.  

Performance
-----------
Zwischen PDO und MYSQLi ergibt sich ein relativ geringer Unterschied von ca. 12% bei einem Insertstatement.

Ergebnis
--------
siehe [data.md](data.md)

Fazit
-------
Aufgrund der Modernität von PDO sowie der Tatsache, dass PDO komplett Objektorientiert ist würde es MYSQLi vorziehen.
