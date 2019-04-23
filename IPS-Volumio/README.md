# IPS-Volumio
   Dieses Modul verbindet Volumio mit IP-Symcon.
     
   ## Inhaltverzeichnis
   1. [Konfiguration](#1-konfiguration)
   2. [Funktionen](#2-funktionen)
   
   ## 1. Konfiguration
   
   Feld | Beschreibung
   ------------ | -------------
   MQTT Topic | Hier wird das MQTT Topic von Volumio eingetragen
   
   ### Radio Sender
   
   Feld | Beschreibung
   ------------ | -------------
   Name | Radio Name
   Stream URL |URL zum Radio Stream
   
   Um die Radio Sender im Webfront nutzen zu können auf den Button "Update Radio Sender" klicken.   
   
   ## 2. Funktionen
   
   **VOLUMIO_UpdateRadioSender($InstanceID)**\
   Mit dieser Funktion kann das Profil für die Radio Sender aktualisiert werden.\
    ```php
    VOLUMIO_UpdateRadioSender(25537);
    ```

   **VOLUMIO_Mute($InstanceID, bool $value)**\
   Mit dieser Funktion kann Volumio stumm geschaltet werden.\
    ```php
    VOLUMIO_Mute(25537, false);
    VOLUMIO_Mute(25537, true);
    ```
    
   **VOLUMIO_Volume($InstanceID, int $value)**\
   Mit dieser Funktion kann die Lautstärke angepasst werden.\
    ```php
    VOLUMIO_Volume(25537, 50);
    ```
    
   **VOLUMIO_VolumeUP($InstanceID)**\
   Mit dieser Funktion kann die Lautstärke angepasst werden. (In 10er Schritten lauter)\
    ```php
    VOLUMIO_VolumeUP(25537);
    ```    

   **VOLUMIO_VolumeDown($InstanceID)**\
   Mit dieser Funktion kann die Lautstärke angepasst werden. (In 10er Schritten leiser)\
    ```php
    VOLUMIO_VolumeDown(25537);
    ```
    
   **VOLUMIO_VolumePushPlus($InstanceID)**\
   Mit dieser Funktion kann die Lautstärke angepasst werden. (In 10er Schritten lauter)\
    ```php
    VOLUMIO_VolumePushPlus(25537);
    ```    
        
   **VOLUMIO_VolumePushMinus($InstanceID)**\
   Mit dieser Funktion kann die Lautstärke angepasst werden. (In 10er Schritten leiser)\
    ```php
    VOLUMIO_VolumePushMinus(25537);
    ```    

   **VOLUMIO_Power($InstanceID, bool $value)**\
   Mit dieser Funktion kann Volumio ein- bzw. ausgeschaltet werden.\
    ```php
    VOLUMIO_Power(25537, true);
    VOLUMIO_Power(25537, false);
    ```
    
   **VOLUMIO_Stop($InstanceID)**\
   Mit dieser Funktion kann die Wiedergabe gestoppt werden.\
    ```php
    VOLUMIO_Stop(25537);
    ```
    
   **VOLUMIO_Pause($InstanceID)**\
   Mit dieser Funktion kann die Wiedergabe pausiert werden.\
    ```php
    VOLUMIO_Pause(25537);
    ```    
    
   **VOLUMIO_Play($InstanceID, int $value (optional))**\
   Mit dieser Funktion kann die Wiedergabe gestartet werden.\
    ```php
    VOLUMIO_Play(25537);
    VOLUMIO_Play(25537, 14); // Springt zu Lied 14
    ```
    
   **VOLUMIO_PlayPlaylist($InstanceID, string $value)**\
   Mit dieser Funktion kann eine Playlist gestartet werden.\
    ```php
    VOLUMIO_PlayPlaylist(25537,'Musik');
    ```
    
   **VOLUMIO_Next($InstanceID)**\
   Mit dieser Funktion kann zum nächsten Lied gesprungen werden.\
    ```php
    VOLUMIO_Next(25537);
    ```
    
   **VOLUMIO_Prev($InstanceID)**\
   Mit dieser Funktion kann zum vorherigen Lied gesprungen werden.\
    ```php
    VOLUMIO_Next(25537);
    ```

   **VOLUMIO_Seek($InstanceID, int $vlaue)**\
   Mit dieser Funktion kann zu einer bestimmten Position im Lied gesprungen werden.\
    ```php
    VOLUMIO_Seek(25537, 50);
    ```