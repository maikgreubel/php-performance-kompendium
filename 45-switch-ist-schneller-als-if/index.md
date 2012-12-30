----
45. switch ist schneller als if 
----

Beispiel
--------
```php
<?php
$var		= "WE HAVE TO TEST IT";
$counter	= 5000;
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
	
	$times[$i]['if']['diff']	= $e - $s;
	
	
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
	
	$times[$i]['switch']['diff']	= $e - $s;
	$times[$i]['diff']				= $times[$i]['if']['diff'] - $times[$i]['switch']['diff'];
}
// Ausgabe bzw. Auswertung der gewonnen Daten
foreach($times as $key=>$time)
{
	$tmp['if']		+= $time['if']['diff'];
	$tmp['switch']	+= $time['switch']['diff'];
	$tmp['diff']	+= $time['diff'];
	echo $key." | ".$time['if']['diff']." | ".$time['switch']['diff']." | ".$time['diff']."<br>";
}
$tmp['if']		= $tmp['if'] / $counter;
$tmp['switch']	= $tmp['switch'] / $counter;
$tmp['diff']	= $tmp['diff'] / $counter;
$tmp['proz']	= ($tmp['if'] / $tmp['switch'] - 1) *100;

echo "<br>".$tmp['if']." | ".$tmp['switch']." | ".$tmp['diff']." | ".$tmp['proz']."<br>";
?>
```
Kommentar
---------
Bei der Verwendung von switch-Anweisungen wird nur auf die Gleichheit der Ausdrücke geprüft. Bei if-Anweisungen kann man auf sehr viele verschiedenen
Bedingungen prüfen. Ich persönlich setzte if-Anweisungen meistens nur zur Überprüfung von Daten ein, wohin gegen ich switch meistens für die Programm-Logik wie z.B. View-Controller einsetzte.

Performance
-----------
Die Messergebnisse können das prognostizierte Verhalten bestätigen allerdings ist der Zuwachs an Performance eher gering (ca. 6%-10%).

Ergebnis
--------
#### Anzahl | if-Zeit | switch-Zeit | Differenz

	0 | 5.96046447754E-6 | 2.14576721191E-6 | 3.81469726562E-6
	1 | 1.90734863281E-6 | 9.53674316406E-7 | 9.53674316406E-7
	2 | 9.53674316406E-7 | 9.53674316406E-7 | 0
	3 | 9.53674316406E-7 | 9.53674316406E-7 | 0
	4 | 9.53674316406E-7 | 9.53674316406E-7 | 0
	5 | 2.14576721191E-6 | 2.14576721191E-6 | 0
	6 | 1.19209289551E-6 | 9.53674316406E-7 | 2.38418579102E-7
	7 | 9.53674316406E-7 | 9.53674316406E-7 | 0
	8 | 9.53674316406E-7 | 9.53674316406E-7 | 0
	9 | 9.53674316406E-7 | 9.53674316406E-7 | 0
	10 | 9.53674316406E-7 | 1.19209289551E-6 | -2.38418579102E-7
###### Vollständige Daten: siehe [data.md](data.md)

Fazit
-------
Kaum messbarer Performance Zuwachs, die Verwendung kommt wahrscheinlich 
<ol>
<li>sehr auf das Einsatzgebiet an</li>
<li>auf die Art der Daten</li>
<li>auf die Art des Vergleichs</li>
</ol>an.




 