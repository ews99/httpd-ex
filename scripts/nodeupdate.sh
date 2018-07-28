#!/bin/bash

HOSTNAME=`hostname`
HOSTIP=`hostname -I`
IPADDR=`gethostip -d ${HOSTIP} | head -n 1`
IPADDRHEX=`gethostip -x ${HOSTIP} | head -n 1`
DOMAINNAME="infra.local"
URL="http://pixelflut.apps.veetikut.com/"

if [ "${HOSTNAME:0:4}" != "node" ] # first 4 characters should be "node"
then
    DESIREDHOSTNAME="node${IPADDRHEX,,}.${DOMAINNAME}"
    hostnamectl set-hostname ${DESIREDHOSTNAME}
    HOSTNAME=`hostname`
fi

curl "${URL}/script.php?action=heartbeat&hostname=${HOSTNAME}&ipaddress=${IPADDR}"
