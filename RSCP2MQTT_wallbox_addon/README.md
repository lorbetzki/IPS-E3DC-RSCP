### IP-Symcon Modul um mehr wie eine E3DC Wallbox zu steuern
 
Die Nutzung des Moduls geschieht auf eigene Gefahr ohne Gewähr.

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang) 
2. [Systemanforderungen](#2-systemanforderungen)
3. [Installation](#3-installation)
4. [Module](#4-module)
5. [ChangeLog](#5-changelog)

## 1. Funktionsumfang

wer mehr wie eine E3DC Wallbox hat, kann mit diesem Modul Wallboxen von ID 1-9 zusätzlich steuern und abfragen. Dieses Modul ist NUR Notwendig, wenn mehr wie eine Wallbox vorhanden ist. Bei einer einzelnen ist dieses Modul ohne Funktion.

## 2. Systemanforderungen
- IP-Symcon ab Version 6.0
- lauffähige Version von [rscp2mqtt](https://github.com/pvtom/rscp2mqtt) min. Version 3.26, die Installation und Einrichtung wird auf der Seite entsprechend erklärt.
- min. zwei E3DC Wallboxen
- In der .config des RSCP2MQTT muss für jede Wallbox ein Eintrag in der der Form WB_INDEX = x erfolgen. Sie [RSCP2MQTT Anleitung](https://github.com/pvtom/rscp2mqtt/blob/main/WALLBOX.md)

## 3. Installation

### RSCP2MQTT
Als Voraussetzung für die Nutzung diese Moduls muss die RSCP2MQTT - Bridge die Werte per MQTT an den Symcon MQTT Server senden. Eine detaillierte Installationsanleitung für den RSCP2MQTT findet ihr unter:

https://github.com/pvtom/rscp2mqtt/blob/main/README.md

### Erstellen der Modul-Instanz
* Über den Module Store das 'RSCP2MQTT Wallbox addon'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen https://github.com/lorbetzki/IPS-E3DC-RSCP.git

### Bestandteile der Instanz Konfiguration
#### Auswahl Liste
Für die möglichen Statusvariablen gibt es eine strutkurierte Auswahlliste in Baumstruktur, in der man Variablen, welche man benötigt, einfach auswählen kann kann. Sobald man eine Variable wieder deaktiviert, wird diese auch gelöscht! Also vorsichtig damit umgehen, um nicht geloggte Daten und Objektverweise zu verlieren


## 4. Module

### 4.1. RSCP2MQTT Wallbox addon

Das Modul "RSCP2MQTT Wallbox addon" ist für Besitzer gedacht, die am E3DC Hauskraftwerk mehrerer Wallboxen betreiben und abfragen/steuern wollen. Wer nur eine Wallbox besitzt, benötigt dieses Modul nicht, es wird auch nicht funktionieren, da die ID weiterer Wallboxen zwischen 1 und 9 liegen muss. Die erste Wallbox hat die 0 und ist mit diesem Modul nicht nutzbar.

#### 4.1.1. Funktionen

### SET_WB Funktionen
die set_wb befehle steuern die Wallboxen im System.

#### RSCP2MQTTWB_set_wb_max_current(int $value)
setzt die Wallbox Ladeleistung, zulässige Werte sind zwischen 6A und 32A in 1A Schritte.

#### RSCP2MQTTWB_set_wb_sun_mode(bool $value)
schaltet den Sonnenmodus für das Laden des Fahrzeuges ein

#### RSCP2MQTTWB_set_wb_charging(bool $value)
Zeigt an, ob das Fahrzeug lädt, ein senden von false während eines Ladevorgangs, unterbricht die Ladung.

#### RSCP2MQTTWB_set_wb_number_of_phases(int $value)
estimmten E3DC Wallboxen können hiermit die Anzahl der Phasen eingestellt werden. 
