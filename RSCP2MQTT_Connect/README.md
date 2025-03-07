### IP-Symcon Modul für die Steuerung des E3DC Hauskraftwerkes über das RSCP Protokoll auf Basis von RSCP2MQTT
 
Die Nutzung des Moduls geschieht auf eigene Gefahr ohne Gewähr.

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang) 
2. [Systemanforderungen](#2-systemanforderungen)
3. [Installation](#3-installation)
4. [Module](#4-module)
5. [SG-Ready](#5-sg-ready)

## 1. Funktionsumfang

Mit diesem Modul kann man das E3DC Hauskraftwerk über das RSCP Protokoll steuern. Da für das RSCP Protokoll leider keine direkte Implementierung in PHP zur Verfügung steht, nutzt dieses Modul die von der RSCP2MQTT - Bridge (https://github.com/pvtom/rscp2mqtt) von PVTOM zur Verfügung gestellten MQTT-Topics zum empfangen und zum senden. RSCP2MQTT ist bspw. auf einem Raspbery PI oder anderen Linuxfähigen Systemen lauffähig.

Der Hauptaugenmerk liegt zu Beginn bei dem Modul auf der Steuerung des Hauskraftwerkes, da hier viel mehr Möglichkeiten zur Verfügung stehen im Vergleich zu der alternativ möglichen Anbindung über Modbus TCP.

Es werden aber nach und nach weitere Status Variablen/Werte integriert werden.

## 2. Systemanforderungen
- IP-Symcon ab Version 7.0
- lauffähige Version von [rscp2mqtt](https://github.com/pvtom/rscp2mqtt), die Installation und Einrichtung wird auf der Seite entsprechend erklärt.

## 3. Installation

### RSCP2MQTT
Als Voraussetzung für die Nutzung diese Moduls muss die RSCP2MQTT - Bridge die Werte per MQTT an den Symcon MQTT Server senden. Eine detaillierte Installationsanleitung für den RSCP2MQTT findet ihr unter:

https://github.com/pvtom/rscp2mqtt/blob/main/README.md

### Erstellen der Modul-Instanz
* Über den Module Store das 'Tibber'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen https://github.com/lorbetzki/IPS-E3DC-RSCP.git

### Bestandteile der Instanz Konfiguration
#### Auswahl Liste
Für die möglichen Statusvariablen gibt es eine strutkurierte Auswahlliste in Baumstruktur, in der man Variablen, welche man benötigt, einfach auswählen kann kann. Sobald man eine Variable wieder deaktiviert, wird diese auch gelöscht! Also vorsichtig damit umgehen, um nicht geloggte Daten und Objektverweise zu verlieren

#### Variablen Namen mit Namespace anlegen
Mit dem Schalter kann man entscheiden ob die Variablen im Namen den Namespace vom jeweiligen Knoten (EMA, BATTERY, ...) im Text vorangestellt bekommen, um die Übersichtlichkeit zu verbessern.

#### Button SORT VARIABLES
Mit dieser Funktion werden die Sortierpositionen der Variablen gemäß der neuen vorgegebenen Default Liste aktualisiert.

#### Button RENAME VARIABLES
Mit dieser Funktion werden die Variablen Namen gemäß der neuen Liste und Übersetzung aktualisiert

## 4. Module

### 4.1. RSCP2MQTT_Connect

Das Modul "RSCP2MQTT_Connect" dient als Schnittstelle zu einem lokal installierten E3DC Hauskraftwerk über das RSCP Protokoll via MQTT Server. Es liefert die Daten des E3DC Hauskraftwerkes als Statusvariablen und bietet die Möglichkeit Einstellungen des Hauskraftwerkes zu ändern. Vor allem bietet das Modul auch die Möglichkeit über die "SET_POWER" Befehle das EMS vom Hauskraftwerk direkt zu steuern, um so das Laden/Entladen direkt zu beeinflussen.

#### 4.1.1 Status Variablen
Die RSCP2MQTT Bridge sendet Updates zu den verschiedenen Variablen nur bei Änderung einer Variablen. Somit kann es sein das Variablen länger kein Update erhalten, wenn keine Änderung vorliegt.

Im folgenden werden die verfügbaren Statusvariablen aufgelistet:

!!!! Muss noch ergänzt werden!!!!

	"Leistung PV" 
	"Leistung Batterie" 
	"Leistung Haus" 
	"Leistung Netz" 
	"Leistung Ext. Quelle" 
	"SOC" 
	"Batterie Zyklen" 
	"Batterie Status" 
	"Maximale Entladeleistung" 
	"Maximale Ladeleistung" 
	"Wettergeführtes Laden" 
	"Aktueller Set Power Wert" 
	"Software Version" 
	"Installierte Leistung" 
	"EMS Modus" 
	"Ladesperre" 
	"Entladesperre" 
	"Notsrom verfügbar" 
	"Ladung begrenz" 
	"Einspeisung Limitiert" 
	"Lade Sperrzeit" 
	"Entlade Sperrzeit" 
	"Betriebsmodus" 


#### 4.1.2. Funktionen

#### RSCP2MQTT_force_update()
Mit der Funktion sendet die RSCP2MQTT-Bridge für alle Werte die Daten. Somit auch für Variablen welche sich nicht geändert haben.

#### RSCP2MQTT_set_refresh_interval(int $value)
Diese Funktion ändert das Update-Intervall mit der die RSCP2MQTT-Bridge die Werte sendet. Es sind Werte zwischen 1 und 10 Sekunden möglich. Damit wird zur Laufzeit die in der Konfiguration der RSCP2MQTT-Bridge definierte Update Zeit geändert.

#### RSCP2MQTT_set_manual_charge(int $value)
Mit dieser Funktion kann man eine manuelle Speicherladung starten. Es muss der Wert in Wh übergeben werden. Dieser kann in 100Wh Schritten erfolgen.

#### RSCP2MQTT_set_weather_regulation(bool $value)
Mit der Funktion kann man das Wetter geführte Laden aktivieren/deaktivieren

#### RSCP2MQTT_set_max_discharge_power(int $value)
Mit dieser Funktion kann man den Wert für die Maximale Entladeleistung des Hauskraftwerkes in Watt setzen. Es können Werte in 100 Watt Schritten gesetzt werden. Der Höchstwert hängt vom vorhandenen Hauskraftwerk ab und muss dementsprechend gesetzt werden.

#### RSCP2MQTT_set_max_charge_power(int $value)
Mit dieser Funktion kann man den Wert für die Maximale Entladeleistung des Hauskraftwerkes in Watt setzen. Es können Werte in 100 Watt Schritten gesetzt werden. Der Höchstwert hängt vom vorhandenen Hauskraftwerk ab und muss dementsprechend gesetzt werden.

### SET_POWER Funktionen
Mit den SET_Power Funktionen kann man dass EMS direkt beeinflussen. Somit hat man alle Möglichkeiten das Lade/Entladeverhalten des Systems komplett selbst zu steuern. Mit diesen Befehlen werden keine Werte fix im Hauskraftwerk gesetzt, sondern die Werte von diesen Befehlen sind nur wenige Sekunden gültig und müssen daher zur Steuerung ständig wiederholt werden. Kommt nach ca 5 Sekunden nicht ein erneuter Wert, fällt das Hauskraftwerk wieder in seinen normnalen Modus zurück.
Über den Parameter $cycles kann man übergeben, für wie viele Intervalle () der Befehl wiederholt werden soll.. Somit muss man nicht alle paar Sekunden den Befehl wiederholen, wenn man den Modus und die Leistungswerte nicht ändern will. Die Intervalldauer entspricht der im RSCP2MQTT eingestellten Intervallzeit.  Wenn die Intervalle von einem Befehl noch nicht abgelaufen sind, können diese mit einem neuen Befehl einfach überschrieben werden.

!!! Mit diesen Befehlen muss man sehr behutsam umgehen, da damit auch evtl. Einspeise-Limits übersteuert werden können. Zusätzlich ist es möglich dass die Ladeleistung höher als die PV Leistung eingestellt wird, und somit auch Netzstrom in den Akku geladen wird. Das Verwenden der Befehle erfolgt auf eigene Verantwortung !!! 

#### RSCP2MQTT_set_power_limits_mode(bool $value)
Die Funktion steuert, ob die Lade-/Entladeleistung gesetzt werden können oder ob die Werte vom E3DC automatisch gesetzt werden.

#### RSCP2MQTT_set_power_mode_auto()
Der Befehl setzt das Hauskraftwerk in den Auto Modus zurück, so dass es wieder im "Normalen" Modus läuft.

#### RSCP2MQTT_set_power_mode_idle(int $cycles)
Dieser Befehl versetz das Hauskraftwerk in den "IDLE" Mode, es wird in dem Modus dann der Akku weder geladen noch entladen.
Über den Parameter $cycles kann man übergeben, für wie viele Intervalle () der Befehl wiederholt werden soll.

#### RSCP2MQTT_set_power_mode_discharge(int $value, int $cycles)
Dieser Befehl versetzt das Hauskraftwerk in den "ENTLADE" Mode, es wird in dem Modus, der Akku mit dem übergebenen Wert entladen.
Über den Parameter $value übergibt man die Entladeleistung in Watt.
Über den Parameter $cycles kann man übergeben, für wie viele Intervalle () der Befehl wiederholt werden soll.

#### RSCP2MQTT_set_power_mode_charge(int $value, int $cycles)
Dieser Befehl versetzt das Hauskraftwerk in den "LADE" Mode, es wird in dem Modus, der Akku mit dem übergebenen Wert geladen.
Über den Parameter $value übergibt man die Ladeleistung in Watt. 
Über den Parameter $cycles kann man übergeben, für wie viele Intervalle () der Befehl wiederholt werden soll.
!! Hier können bei nicht reinen DC Systemen auch Werte übergeben werden, welche höher als die PV Leistung sind, und somit eine Netzladung auslösen!!

#### RSCP2MQTT_set_power_mode_gridcharge(int $value, int $cycles)
Dieser Befehl versetzt das Hauskraftwerk in den "NETZLADE" Mode, es wird in dem Modus, der Akku mit dem übergebenen Wert aus dem Netz geladen.
Über den Parameter $value übergibt man die Ladeleistung in Watt. 
Über den Parameter $cycles kann man übergeben, für wie viele Intervalle () der Befehl wiederholt werden soll.
!! Hier wird aus dem NETZ geladen !!


### SET_WB Funktionen
die set_wb befehle steuern die Wallboxen im System. Besitzt man mehrere Wallboxen muss man vorher mit set_wb_index() die passende ID (Zahlen von 0-9) vorgeben. Besitzt man nur eine, benötigt man dies nicht.

#### RSCP2MQTT_set_wb_index(int $value)
besitzt man mehr wie eine Wallbox muss mit dem Befehl die ID, eine Zahl zwischen 0-9, mitgegeben werden. Index 0 entspricht dabei die erste Wallbox

#### RSCP2MQTT_set_wb_battery_to_car_mode(bool $value)
hiermit wird die Entladung der Hausbatterie durch die Wallbox erlaubt. 

#### RSCP2MQTT_set_wb_battery_before_car_mode(bool $value)
setzt die Ladepriorität fest. Dabei bedeutet "true", das die Hausbatterie vorrang hat, false die Wallbox zuerst 

#### RSCP2MQTT_set_wb_max_current(int $value)
setzt die Wallbox Ladeleistung, zulässige Werte sind zwischen 6A und 32A in 1A Schritte.

#### RSCP2MQTT_set_wb_sun_mode(bool $value)
schaltet den Sonnenmodus für das Laden des Fahrzeuges ein

#### RSCP2MQTT_set_wb_charging(bool $value)
Zeigt an, ob das Fahrzeug lädt, ein senden von false während eines Ladevorgangs, unterbricht die Ladung.

#### RSCP2MQTT_set_wb_battery_discharge_until(int $value)
mittels dieser Funktion kann gesteuert werden, bis zum welchen SOC der Hausakku entleert werden darf

#### RSCP2MQTT_set_wb_disable_battery_at_mix_mode(bool $value)
Entleerung des Hausakkus im Mischmodus verbieten

#### RSCP2MQTT_set_wb_number_of_phases(int $value)
bestimmten E3DC Wallboxen können hiermit die Anzahl der Phasen eingestellt werden.
Achtung, seit der E3DC-Firmwareversion 2024_028 wird die Anzahl der Phasen auch zur Berechnung der PV-Überschussleistung verwendet. Wenn Ihr also die Phasen bspw auf 3 stehen habt, aber ein Fahrzeug besitzt was nur 1-Phasig lädt, so wird als Berechnung dennoch 3x6Ax240V = 4320W (Mindestleitung) verwendet. Ihr könnt mit diesem Befehl also der E3DC mitteilen, das nur 1 Phase zur Berechnung benutzt wird (1x6Ax240V = 1440W)

#### RSCP2MQTT_set_limit_charge(int $value)
setzt ein Ladelimit für den Hausakku in %, hilfreich wenn man im Urlaub ist und der Akku nicht auf 100% geladen werden muss. Bei einem tageswechsel wird dieser Wert zurückgesetzt. Sollte dies verhindern werden, so ist zusätzlich RSCP2MQTT_set_limit_charge_durable() zu verwenden.

#### RSCP2MQTT_set_limit_discharge(int $value)
setzt ein entladelimit für den Hausakku in %, hilfreich wenn man im Urlaub ist und der Akku nicht auf 0% entladen werden soll. Bei einem tageswechsel wird dieser Wert zurückgesetzt. Sollte dies verhindern werden, so ist zusätzlich RSCP2MQTT_set_limit_discharge_durable() zu verwenden.

#### RSCP2MQTT_set_limit_discharge_durable(bool $value)
true sorgt dafür, das bei einem Tagwechsel das gesetzte Entladelimit nicht zurückgesetzt wird.

#### RSCP2MQTT_set_limit_charge_durable(bool $value)
true sorgt dafür, das bei einem Tagwechsel das gesetzte Ladelimit nicht zurückgesetzt wird.

#### RSCP2MQTT_set_limit_discharge_by_home_power(int $value)
hiermit kann man festlegen, ab wieviel Watt Hausverbrauch nicht mehr der Hausakku entladen werden soll. Kann bspw benutzt werden, wenn man keine E3DC Wallbox hat und gerade ein Fahrzeug lädt. 


#### RSCP2MQTT_activate_pvi_requests(bool $value)
#### RSCP2MQTT_activate_pm_request(bool $value)

## 5. SG-Ready
um sich den SG-Ready Statis anzeigen zu lassen, ist rscp2mqtt min in Version 3.34 notwendig. Außerdem muss in der .config von rscp2mqtt folgendes eingetragen sein

	ADD_NEW_REQUEST_AT_START=0:TAG_SGR_REQ_HW_PROVIDER_LIST-0
	ADD_NEW_TOPIC=TAG_SGR_HW_PROVIDER:TAG_SGR_INDEX:_:1:0:sg_ready/1/provider/index
	ADD_NEW_TOPIC=TAG_SGR_HW_PROVIDER:TAG_SGR_NAME:_:1:0:sg_ready/1/provider/name
	ADD_NEW_REQUEST=0:TAG_SGR_REQ_COOLDOWN_END-0
	ADD_NEW_TOPIC=0:TAG_SGR_COOLDOWN_END:_:1:0:sg_ready/cooldown_end
	ADD_NEW_REQUEST=0:TAG_SGR_REQ_USED_POWER-0
	ADD_NEW_TOPIC=0:TAG_SGR_USED_POWER:W:1:0:sg_ready/used_power
	ADD_NEW_REQUEST=0:TAG_SGR_REQ_GLOBAL_OFF-0
	ADD_NEW_TOPIC=0:TAG_SGR_GLOBAL_OFF:_:1:0:sg_ready/global_off
	ADD_NEW_REQUEST=TAG_SGR_REQ_DATA:TAG_SGR_INDEX:0-0
	ADD_NEW_REQUEST=TAG_SGR_REQ_DATA:TAG_SGR_REQ_STATE-1
	ADD_NEW_TOPIC=TAG_SGR_DATA:TAG_SGR_INDEX:_:1:0:sg_ready/1/index
	ADD_NEW_TOPIC=TAG_SGR_DATA:TAG_SGR_STATE:_:1:0:sg_ready/1/status
	ADD_NEW_TOPIC=TAG_SGR_DATA:TAG_SGR_AKTIV:_:1:0:sg_ready/1/active