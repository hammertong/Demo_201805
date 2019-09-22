# SETUP

## configurare proxy apache per la websocket  
	
	assicurarsi che sianno caricati i moduli mod_proxy e mod_proxy_wstunnel  
	nel mio Fedora 30 erano abilitati di default dalla configurazione base di apache:  
	``
		LoadModule proxy_module modules/mod_proxy.so  
		LoadModule proxy_wstunnel_module modules/mod_proxy_wstunnel.so  
	``  
	portarsi nel virtualhost ssl desiderato  
	e.g.:   
	``
	<VirtualHost _default_:443>  
	...  
		RewriteEngine On  
		ProxyRequests Off  
		ProxyPreserveHost On  
		ProxyPass /wss/ ws://127.0.0.1:8443/  
		ProxyPassReverse /wss/ http://127.0.0.1:8443/  
	...  
	``

## installare webapp HTML  

	  - salvare la cartella www in una location del virtualhost con il proxy  
	    sopra configurato  
	  - modificare la lista delle sorgenti rtsp nel file index.html  
	    all'interno della <select> di riga 90 circa  

## riavviare apache  
  
## avviare websocket server locale  
  
	  - portarsi nella cartella di websocket.py e lanciare lo script  
  	  - rendere automatica questa operazione aggiungendola alla configurazione del systemd  


## note finali sulla configurazione  
  
	per seguenti moduli è configurare  
  
>>	./websocket.py da linea di comando:   
>>		- listener websocket  
>>		- ssl e certificati per il listener websocket  
  
>>	./webrtc da linea di comando  
>>		- client websocket (ws,wss porta)  
>>		- stun server  
  
>>	./javascript  
>>		- lista delle risorse rtsp nella rete del websocket server  
>>		- location apache upgradable to websocket (vedi configurare proxy apache per la websocket)  
  

# TODO - PLANNING 
- verify if it works on symmetric and asymmetric NAT 

# RESOURCES / H264 ISSUES
https://github.com/centricular/gstwebrtc-demos/issues/  
https://github.com/centricular/gstwebrtc-demos/issues/18  
What are the stream properties of the h.264 being sent by the RTSP server? What profile level, level, bit-depth, etc? Browsers only support a subset of those. 

# GENERAL PRESCRIPTIONS 

## Gstreamer 
put here in .bashrc:
> export GST_PLUGIN_SYSTEM_PATH=/usr/lib64/gstreamer-1.0  
> export GST_PLUGIN_SYSTEM_PATH_1_0=/usr/lib64/gstreamer-1.0  
> export GST_DEBUG=1

# TROUBLESHOOTING  

## Quando non funziona il caricamento dei plugin, ma i plugin sono installati  
- Alzare il livello export GST_DEBUG (e.g.: 4)  
- dai log trovare la posizione del file di cache dei plugin di gstreamer  
- rimuovere il file  

## Avviare un flusso video di prova di test H264
- vedere test-video.c in rtsp/

# SETUP LIBRARIES

## Install software on Linux

`` 
sudo dnf search gstreamer1*  
``

``
sudo dnf install -y gstreamer1.x86_64 gstreamer1-devel.x86_64 gstreamer1-vaapi.x86_64  gstreamer1-libav.x86_64 gstreamer1-plugins-fc.x86_64 gstreamer1-rtsp-server.x86_64 gstreamer1-plugins-base.x86_64 gstreamer1-plugins-good.x86_64 gstreamer1-plugins-ugly.x86_64 gstreamer1-plugins-good-qt.x86_64 gstreamer1-plugins-bad-free.x86_64 gstreamer1-plugins-good-gtk.x86_64 gstreamer1-plugins-ugly-free.x86_64 gstreamer1-rtsp-server-devel.x86_64 gstreamer1-plugins-base-devel.x86_64 gstreamer1-plugins-base-tools.x86_64 sudo gstreamer1-libav.x86_64 gstreamer1-plugins-good-extras.x86_64 gstreamer1-plugins-bad-freeworld.x86_64 gstreamer1-plugins-bad-free-devel.x86_64 gstreamer1-plugins-bad-free-extras.x86_64 gstreamer1-plugins-ugly-free-devel.x86_64 gstreamer1-plugins-bad-free-wildmidi.x86_64 gstreamer1-plugins-bad-free-fluidsynth.x86_64 gstreamer1-plugins-bad-nonfree.x86_64 json-glib.x86_64 json-glib-devel.x86_64 json-glib-tests.x86_64 libnice-gstreamer1.x86_64 h264enc x264.x86_64 x264-libs.x86_64 x264-devel.x86_64
`` 

## FEDORA Issues: https://fedoraproject.org/wiki/OpenH264

>> sudo dnf config-manager --set-enabled fedora-cisco-openh264  
>> sudo dnf install gstreamer1-plugin-openh264 mozilla-openh264  

# GST webrtc demos / sources 

> https://www.youtube.com/watch?v=jcYoyVRAQGk  
> https://github.com/centricular/gstwebrtc-demos  

# RUN 

## Run Signaling:

> cd signaling  
> pip3 install --user websockets  
> ./generate_cert.sh  
> ./simple-server.py  

## Run rtsp gateway with gstreamer

> cd gst  
> gcc webrtc-sendrecv.c $(pkg-config --cflags --libs gstreamer-webrtc-1.0 gstreamer-sdp-1.0 libsoup-2.4 json-glib-1.0) -o webrtc-sendrecv  
> ./webrtc-sendrecv --disable-ssl --server=wss://127.0.0.1:8443 --peer-id=<OUR_PEER_ID>  

## Open Firefox/Chrome

-- Accept WebSoket Signaler certificate at url https://127.0.0.1:8443/  
-- open url file://<your_project_disk_path>/gstwebrtc-demos/sendrecv/js/index.html  
   or https://<your_virtual_host>[:your_port]/<your_project_apache_location>/gstwebrtc-demos/sendrecv/js/index.html  


# Optional JANUS gateway test

> COMPILAZIONE & AVVIO JANUS  
>> sh autogen.sh  
>> ./configure --prefix=/opt/janus --disable-websockets --disable-data-channels --disable-rabbitmq --disable-mqtt  
make  

> installazione
>> sudo mkdir /opt/janus && sudo chown federico:federico /opt/janus  
>> make install  
>> make configs  
>> cp janus.plugin.streaming.jcfg /opt/janus/etc/janus/  

> avvio:
>> ./janus -l -D -d 4  

