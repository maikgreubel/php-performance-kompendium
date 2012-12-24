------
14. Fehlerunterdrückung kostet Zeit
------
Beispiel
-------
```php
<?php
$count = 100;
$times = array();
function x() { }

for($a = 1; $a <= $count; $a++)
{
	$s = microtime(true);
	for ($i = 0; $i < 100000; $i++)
	{
		x();
	}
	$e = microtime(true);
	
	$times[$a]['nosupression'] = $e - $s;
	
	$s = microtime(true);
	for ($i = 0; $i < 100000; $i++)
	{
		@x();
	}
	$e = microtime(true);
	
	$times[$a]['supression'] = $e - $s;
	$times[$a]['diff']		 = $times[$a]['supression'] - $times[$a]['nosupression'];
}

foreach($times as $key=>$time)
{
	$tmp['no'] += $time['nosupression'];
	$tmp['su'] += $time['supression'];
	$tmp['di'] += $time['diff'];
	echo $key." | ".$time['nosupression']." | ".$time['supression']." | ".$time['diff']."<br>";
}

$tmp['no'] += $time['nosupression'] / $count;
$tmp['su'] += $time['supression'] / $count;
$tmp['di'] += $time['diff'] / $count;
$tmp['pr'] = (($time['nosupression'] / $time['supression']) - 1) *100;

echo "<br>".$tmp['no']." | ".$tmp['su']." | ".$tmp['di']." | ".$tmp['pr']."<br>"
?>
```
Kommentar
---------
Zwar kostet die Fehlerunterdrückung sehr viel Zeit allerdings gibt es durchaus berechtigte Einsatzgelegenheiten.

Performance
-----------
Die Fehlerunterdrückung mit @ ist ca. 70% langsamer als ohne.

Ergebnis
---------
###### Anzahl | ohne-Zeit | mit-Zeit | Differenz
```
1 | 0.0310530662537 | 0.110462903976 | 0.0794098377228
2 | 0.0303609371185 | 0.108788013458 | 0.0784270763397
3 | 0.0306749343872 | 0.10863494873 | 0.0779600143433
4 | 0.0303831100464 | 0.108095884323 | 0.0777127742767
5 | 0.0303330421448 | 0.108812093735 | 0.07847905159
6 | 0.0302290916443 | 0.108863115311 | 0.0786340236664
7 | 0.0303871631622 | 0.109043836594 | 0.0786566734314
8 | 0.0301048755646 | 0.109512805939 | 0.0794079303741
9 | 0.0301399230957 | 0.108958005905 | 0.0788180828094
10 | 0.0297329425812 | 0.108931064606 | 0.0791981220245
[...]
```
###### Vollständige Daten: siehe [data.md](data.md)

Fazit
------
Sollte es nicht unbedingt nötig sein würde ich auf eine Unterdrückung der Fehler mit @ verzichten.