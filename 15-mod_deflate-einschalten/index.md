---
15. Apache's mod_deflate verwenden
---
Beispiel
--------

#### Aktivieren des Moduls und Konfiguration
Zunächst muss das Modul von Apache geladen sein, damit die Ausgabe von PHP komprimiert an den Client (Browser) gesendet werden kann. Dazu bearbeitet man die httpd.conf im Unterorder *conf* des Apache-Installationsordners. In den meisten Fällen wird die folgende Zeile bereits vorhanden aber evtl. auskommentiert (Raute-Zeichen am Anfang der Zeile) sein:

```
LoadModule deflate_module modules/mod_deflate.so
```

Desweiteren werden wir in der Konfiguration Parameter verwenden, die durch andere Module bereit gestellt werden. Es handelt sich hierbei um **filter\_module** und **headers\_module**. Diese müssen ebenfalls aktiviert werden, sofern sie das noch nicht sind.

Nun kann man die Konfiguration so festlegen, das PHP-Ausgaben komprimiert ausgeliefert werden. Dazu fügt man (am besten ans Ende der httpd.conf) folgende Sektion ein:

	<IfModule deflate_module>
		<Location />
			<IfModule filter_module>
				# Insert filter
				AddOutputFilterByType DEFLATE text/html
			
				# Netscape 4.x hat ein paar Probleme...
				BrowserMatch ^Mozilla/4         gzip-only-text/html
			
				# Netscape 4.06-4.08 hat ein paar mehr Probleme
				BrowserMatch ^Mozilla/4\.0[678] no-gzip
			
				# MSIE gibt sich als Netscape aus, aber ist ok
				BrowserMatch \bMSIE             !no-gzip !gzip-only-text/html
				# Bilder nicht komprimieren
				SetEnvIfNoCase Request_URI \.(?:gif|jpe?g|png)$ no-gzip dont-vary
			</IfModule>
			<IfModule headers_module>
				# Vergewissern, das Proxies den richtigen Inhalt weitergeben
				Header append Vary User-Agent env=!dont-vary
			</IfModule>
		</Location>
	</IfModule>

Es gibt noch diverse andere Konfigurationsparameter und an dieser Stelle sei auf die [Dokumentation](http://httpd.apache.org/docs/2.0/mod/mod_deflate.html) verwiesen.


#### Überprüfung der Konfiguration

Am besten sieht man den Unterschied, wenn man eine Vorher-/Nachher-Analyse vornimmt. Hier wurde einfach ein beliebiges Script einmal ohne und einmal mit aktivierter Komprimierung abgeholt:

**Aufruf mit deaktivierter Komprimierung**

	http://localhost/phpinfo.php
	
	GET /phpinfo.php HTTP/1.1
	Host: localhost
	User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0
	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
	Accept-Language: de-de,de;q=0.8,en-us;q=0.5,en;q=0.3
	Accept-Encoding: gzip, deflate
	DNT: 1
	Connection: keep-alive
	Referer: http://localhost/
	Cache-Control: max-age=0
	
	HTTP/1.1 200 OK
	Date: Sat, 29 Dec 2012 13:21:14 GMT
	Server: Apache/2.4.3 (Win32) PHP/5.4.8 OpenSSL/1.0.1c
	X-Powered-By: PHP/5.4.8
	Keep-Alive: timeout=5, max=100
	Connection: Keep-Alive
	Transfer-Encoding: chunked
	Content-Type: text/html

**Aufruf mit aktivierter Komprimierung**

	http://localhost/phpinfo.php
	
	GET /phpinfo.php HTTP/1.1
	Host: localhost
	User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0
	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
	Accept-Language: de-de,de;q=0.8,en-us;q=0.5,en;q=0.3
	Accept-Encoding: gzip, deflate
	DNT: 1
	Connection: keep-alive
	Referer: http://localhost/
	Cache-Control: max-age=0
	
	HTTP/1.1 200 OK
	Date: Sat, 29 Dec 2012 13:24:35 GMT
	Server: Apache/2.4.3 (Win32) PHP/5.4.8 OpenSSL/1.0.1c
	X-Powered-By: PHP/5.4.8
	Vary: Accept-Encoding,User-Agent
	Content-Encoding: gzip
	Content-Length: 13069
	Keep-Alive: timeout=5, max=100
	Connection: Keep-Alive
	Content-Type: text/html

Es sind einige Unterschiede in den Responses festzustellen. Zum einen wird vom Server jetzt der Response-Header "Content-Encoding" auf gzip gesetzt. Außerdem muss der Client (Browser) wissen, wie groß der komprimierte Datenstrom ist, um ihn korrekt dekomprimieren zu können. Daher wird auch der Response-Header "Content-Length" mit der entsprechenden Länge zurück gegeben. Außerdem wird das Response-Feld "Vary" gesendet, was sich auf die Teilaspekte des Cachings von Inhalten bezieht. An dieser Stelle sei auf das [RFC 2616 (Sektion 14.44)](http://tools.ietf.org/html/rfc2616#section-14.44) verwiesen.

Kommentar
---------

**Anmerkung zur "Content-Length":**

[RFC 2616, Sektion 14.13](http://tools.ietf.org/html/rfc2616#section-14.13)

Leider ist dieses Response-Feld optional. Wenn man gezwungen wäre, als Web-Entwickler alle Standards einzuhalten, wäre dies mitunter zu begrüßen. Die Angabe der Länge des Inhalts gibt dem Browser das Signal: Lese so-und-so-viele Zeichen, dann ist die Übertragung abgeschlossen. Wenn dem Browser nicht mitgeteilt wird, wieviel Bytes an Daten denn kommen werden, muss der Browser auf das Ende-Zeichen (EOF) warten. Wird dieses Zeichen nicht gesendet oder kommt es schlicht nicht an, wartet der Browser einfach so lange weiter, bis das Zeichen dann doch kommt oder ein Timeout eintritt. Prinzipiell ist die Länge des Inhalts eine wertvolle Information für den Browser und wird von verschiedenen Stellen auch als Performance-Kriterium aufgestellt. Auf den Content-Length wird in einem **späteren** Kapitel eingegangen.

**Anmerkungen zur Konfiguration**

Es gibt noch diverse andere Konfigurationseinstellungen für das deflate Modul des Apachen. Sie alle hier zu erwähnen und zu besprechen würde den Rahmen sprengen, daher wird an dieser Stelle auf die hervorrangende [Dokumentation](http://httpd.apache.org/docs/2.2/mod/mod_deflate.html) verwiesen. Außerdem sei noch zu erwähnen, das es durchaus Unterschiede zwischen den Apache-Versionen geben kann, was Parameternamen und/oder Abhängigkeiten zu anderen Modulen angeht. Auch hier hilft die Dokumentation für die jeweilige Version vom Apache HTTP Server weiter.

Performance
-----------
Die Verwendung von komprimierten Daten macht sich vor allem dann bemerkbar, wenn der Inhalt sehr groß ist. Denn dadurch wird eine geringere Bandbreite notwendig, weil weniger Daten übertragen werden. Es gibt natürlich einen Haken an der Sache, denn Komprimierung ist ein rechenaufwendiger Prozess, was sich an der Anzahl von gleichzeitigen Requests bemerkbar macht, die im Falle der aktivierten Komprimierung somit nach unten tendiert.


Ergebnis
--------
####Harte Fakten mit dem Apache Benchmark (ab)

Kurz und ohne viele Worte. Aufruf-Parameter im Beispiel:

```ab -n 100 -c 10 http://localhost/phpinfo.php```

**Ohne Komprimierung**

	Total transferred:      7935890 bytes
	HTML transferred:       7917890 bytes
	Requests per second:    342.45 [#/sec] (mean)
	Time per request:       29.202 [ms] (mean)
	Time per request:       2.920 [ms] (mean, across all concurrent requests)
	Transfer rate:          26539.18 [Kbytes/sec] received

**Mit Komprimierung**

	Total transferred:      7939289 bytes
	HTML transferred:       7917889 bytes
	Requests per second:    110.37 [#/sec] (mean)
	Time per request:       90.605 [ms] (mean)
	Time per request:       9.061 [ms] (mean, across all concurrent requests)
	Transfer rate:          8557.14 [Kbytes/sec] received

Fazit
-----

Es ist schwierig etwas positives oder negatives über die Komprimierung zu sagen. Sie hat auf jeden Fall Vorteile, wenn es um große Datenmengen geht, die es gilt an den Browser zu übertragen. Sie kommt jedoch mit dem Malus der geringeren Auslieferungsgeschwindigkeit sowie der Beschränkung der gleichzeitig bearbeiteten Requests aufgrund der höheren CPU-Auslastung. Man sollte hier wirklich im Test ausprobieren, ob die Auslieferung mit aktivierter Komprimierung stattfinden soll oder nicht. Das Tool [ab](http://httpd.apache.org/docs/2.2/programs/ab.html) kann hier Entscheidungshilfe leisten. Normalerweise ist es bei jeder Apache-Installation dabei (im *bin* Ordner der Installation).

Es gibt noch andere Techniken, die Daten komprimiert dem Browser zu senden. In einem **anderen** Kapitel wird noch mod_gzip untersucht und es wird auch eine Methode vorgestellt, mit der man ganz ohne Konfigurationsänderung des Apachen komprimiert Daten (Stichwort Output-Buffering) senden kann.