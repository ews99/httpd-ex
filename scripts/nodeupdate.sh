#!/bin/bash

HOSTNAME=`hostname`
HOSTIP=`hostname -i`
IPADDR=`gethostip -d ${HOSTIP} | head -n 1`
IPADDRHEX=`gethostip -x ${HOSTIP} | head -n 1`
IFACE=`ip route show default | awk '/default/ {print $5}'`
MACADDR=`cat /sys/class/net/${IFACE}/address`
DOMAINNAME="veetikut.com"
URL="http://pixelflut.apps.veetikut.com/"

if [ "${HOSTNAME:0:4}" != "node" ] # first 4 characters should be "node"
then
    DESIREDHOSTNAME="node${IPADDRHEX,,}.${DOMAINNAME}"
    hostnamectl set-hostname ${DESIREDHOSTNAME}
    HOSTNAME=`hostname`
fi

curl "${URL}/script.php?action=heartbeat&hostname=${HOSTNAME}&ipaddress=${IPADDR}&macaddress=${MACADDR}&iface=${IFACE}"
