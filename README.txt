Simon Brüchner, Mai 2013

Kapitel als XML
===============
Im Ordner "/PhoneGap/xml" befinden sich alle Kapitel als XML Dateien. Aktuelle XMLs können von http://kolchose.org/simon/volxbibelwiki/export/ exportiert werden.


XCode
=====
Im Ordner XCode ist der verwendete Code für die erstellung der App mit PhoneGap.


XML in HTML rendern
===================
"/xml_to_html.php" mit PHP aufrufen, dieses Script erstellt pro Kapitel-XML-Datei (z.B. "01_Matthaeus.xml") eine HTML-Datei (z.B. "matthaeus_1.html") im Ordner "/PhoneGap/html/". Dies ist schon für die beigefügten XMLs geschehen. 

Das Script erstellt weiter die Datei "/PhoneGap/kapitelliste.html" neu, diese kann bei Bedarf in "index.html" erneut eingefügt werden.


Gerenderte Inhalte
==================
Die mit PHP fertig gerenderten HMTL-Kapitel-Dateien von "/PhoneGap/html/*.html" müssen nach "/XCode/www/html/*.html" kopiert werden. Sowie und "/PhoneGap/index.html" nach "/XCode/www/index.html"

Weiter muss der Inhalt des Ordners "/PhoneGap/iui/" komplett nach "/XCode/iui/" kopiert werden.

Danach App compilen... :-)


ToDos
=====
- iui updaten
- PhoneGap updaten
- Autorenliste updaten


