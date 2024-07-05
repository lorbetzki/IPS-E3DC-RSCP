### IP-Symcon Library für die Steuerung des E3DC Hauskraftwerkes über das RSCP Protokoll
 
Diese Modul wurde von Philipp Hirzel entwickelt aufgrund von Zeitmangel aber leider nicht veröffentlicht. Dankenswerterweise durfte ich das Modul übernehmen und der Symcon Community zur Verfügung stellen. Bei fragen oder wünschen gerne Meldung an mich.
  
Die Nutzung des Moduls geschieht auf eigene Gefahr ohne Gewähr. Es handelt sich hierbei um einen frühen Entwicklungsstand.

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang) 
2. [Systemanforderungen](#2-systemanforderungen)
3. [Installation](#3-installation)
4. [Module](#4-module)

## 1. Funktionsumfang
Die E3DC-RSCP Library stellt aktuell ein Modul zur verfügung mit dem das E3DC Hauskraftwerk über das RSCP Protokoll ausgelesen und gesteuert werden kann. Da für das RSCP Protokoll leider keine direkte Implementierung in PHP zur Verfügung steht, nutzt dieses Module das MQTT Protokoll um die Daten zu empfangen und zu senden.

Hierzu wird eine [zusätzliche](https://github.com/pvtom/rscp2mqtt) Software benötigt, welche das RSCP Protokoll auf MQTT und umgekehrt umsetzt.

Einen genauen Funktionsumfang des jeweiligen Moduls und die benötigten Voraussetzungen wird in der Modul Readme detailiert beschrieben.

## 2. Systemanforderungen
- IP-Symcon ab Version 6.0
- lauffähige Version von [rscp2mqtt](https://github.com/pvtom/rscp2mqtt), die Installation und Einrichtung wird auf der Seite entsprechend erklärt.

## 3. Installation

### Installation des Moduls
Das Modul ist im Symcon Modul Store verfügbar und kann von dort einfach installiert werden. Solange das Modul noch im Beta Kanal veröffentlicht ist muss mit dem genauen Namen "E3DC RSCP Connect (MQTT)" gesucht werden.

## 4. Module

### 4.1. RSCP2MQTT_Connect
Modul um die Steuerung des E3DC Hauskraftwerkes über die RSCP2MQTT Bridge zu implementieren.
https://github.com/lorbetzki/IPS-E3DC-RSCP/blob/main/RSCP2MQTT_Connect/README.md

