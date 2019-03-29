#REQUIREMENTS

- gestione scatto dei 40 smartphone
- gestione avvio e stop registrazione video dei 40 smartphone
- gestione zoom dei 40 smartphone
- gestione attivazione e disattivazione split screen dei 40 smartphone
- gestione avvio modalità immagine di sfondo
- creazione della app e pubblicazione
- installazione della app su smartphone con gestione remota da computer linux


#Topic di statistiche generali del broker:

mosquitto_sub -v -t \$SYS/#
mosquitto_sub -d -t '$SYS/broker/clients/active'


#Consumazione della coda upstream dal backend

##Ricezione messaggi provenienti da android 
...
export topic="/downstream/intent/montini.f.T1"
mosquitto_sub -t /upstream/# -v
...

#Produzione sulla coda di topic downstream

##Scatto fotogramma
... 
mosquitto_pub -t $topic -m "photo"
...

##Wakeup device
...
mosquitto_pub -t $topic -m "wakeup"
mosquitto_pub -t $topic -m "info"
...

## Zoom e traslazione
...
mosquitto_pub -t $topic -m "transform 2.3"
imosquitto_pub -t $topic -m "transform 3 -550 -800"
...

## Switch camera facing
...
mosquitto_pub -t $topic -m "switch"
...

## Attivazione app quando viene mandata in background
...
mosquitto_pub -t "/downstream/activate" -m "-"
...

P.S.: Quando l'app non è in foreground e il device è spento:
eseguire nell'ordine Activate, Wakeup


##ADB Comandi utili
### fotogramma con intent
...
adb shell am broadcast -a montini.f.T1 -es message=photo
...  

##Per fare funzionare Firebase occorre abilitare i paccketti ply service 
...
pm enable com.google.android.gsf
pm enable com.google.android.gms
pm enable com.google.android.gsf.login
...

##Comandi utili per elencare pacchetti abilitati/disabilitatai
...
adb shell pm list packages
adb shell pm list packages -f # See their associated file.
adb shell pm list packages -d # Filter to only show disabled packages.
adb shell pm list packages -e # Filter to only show enabled packages.
adb shell pm list packages -s # Filter to only show system packages.
adb shell pm list packages -3 # Filter to only show third party packages.
adb shell pm list packages -i # See the installer for the packages.
adb shell pm list packages -u # Also include uninstalled packages.
adb shell pm list packages --user <USER_ID> # The user space to query.
...


