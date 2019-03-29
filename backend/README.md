
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

