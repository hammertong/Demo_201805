#!/bin/sh
ip=""
if [ "$1" = "" ]
then
  ip=`ifconfig | grep broadcast | grep inet | awk '{print $2}'`
else
  ip=$1
fi
if [ "$ip" = "" ]
then
  echo "cannot find default local ip addess with broadcast enabled!"
  echo "Usage:"
  echo "$0 <broker-ip-address>"
  exit 1
fi 
echo "myip is $ip"
php broadcast.php -m "brokerUrl tcp://$ip:1883"

