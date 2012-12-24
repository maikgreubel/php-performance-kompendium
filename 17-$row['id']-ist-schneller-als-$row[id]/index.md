-----
17. $row['id'] ist schneller als $row[id]
-----

Beispiel
--------
```php
<?php
$times = array();
$count = 5000;
for($i = 1; $i <= $count; $i++)
{
	$s = microtime(true);
	$arry[id] = 'THIS IS AN VERY USELESS STRING';
	$e = microtime(true);
	$times[$i]['noqout'] = $e - $s;
	
	$s = microtime(true);
	$arry['id'] = 'THIS IS AN VERY USELESS STRING';
	$e = microtime(true);
	
	$times[$i]['qout'] = $e - $s;
	$times[$i]['diff'] = $times[$i]['noqout'] - $times[$i]['qout'];
}

foreach($times as $key=>$time)
{
	$tmp['noqout'] += $time['noqout'];
	$tmp['qout'] += $time['qout'];
	$tmp['diff'] += $time['diff'];
	
	echo $key." | ".$time['noqout']." | ".$time['qout']." | ".$time['diff']."<br>";
}

echo $tmp['noqout'] / $count," | ";
echo $tmp['qout'] / $count," | ";
echo $tmp['diff'] / $count," | ";
echo (($time['noqout'] / $time['qout']) -1) *100, "<br>";
?>
```
Kommentar
---------
Die explizite Schreibweise ist wie erwartet schneller. 

Performance
-----------
Anhand der Messungen ist klar ersichtlich das es einen starken Zuwachs an Performance gibt. Der Zuwachs beläuft sich auf ca. 100%-125%.

Ergebnis
--------
###### Anzahl | Variante 1 Zeit | Variante 2 Zeit | Differenz
```
1 | 2.19345092773E-5 | 1.90734863281E-6 | 2.00271606445E-5
2 | 3.09944152832E-6 | 1.19209289551E-6 | 1.90734863281E-6
3 | 3.09944152832E-6 | 2.14576721191E-6 | 9.53674316406E-7
4 | 3.09944152832E-6 | 9.53674316406E-7 | 2.14576721191E-6
5 | 2.86102294922E-6 | 1.19209289551E-6 | 1.66893005371E-6
6 | 2.14576721191E-6 | 1.90734863281E-6 | 2.38418579102E-7
7 | 2.86102294922E-6 | 9.53674316406E-7 | 1.90734863281E-6
8 | 1.90734863281E-6 | 9.53674316406E-7 | 9.53674316406E-7
9 | 1.90734863281E-6 | 0 | 1.90734863281E-6
10 | 2.86102294922E-6 | 9.53674316406E-7 | 1.90734863281E-6
[...]
```
###### Vollständige Daten: siehe data.md

Fazit
-----
Es empfiehlt sich folgende Schreibweise zu verwenden: $row['id'].