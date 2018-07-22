#!/bin/bash

HOSTNAME=`hostname`
HOSTIP=`hostname -I`
IPADDR=`gethostip -d ${HOSTIP} | head -n 1`
IPADDRHEX=`gethostip -x ${HOSTIP} | head -n 1`
DOMAINNAME="infra.local"
MASTERIP="172.18.21.13"
URL="http://pixelflut-nodes-pixelflut-nodes.router.default.svc.cluster.local"

if [ "${HOSTNAME:0:4}" != "node" ] # first 4 characters should be "node"
then
    DESIREDHOSTNAME="node${IPADDRHEX,,}.${DOMAINNAME}"
    hostnamectl set-hostname ${DESIREDHOSTNAME}
    HOSTNAME=`hostname`
fi

echo "$HOSTNAME $DOMAINNAME $IPADDR $IPADDRHEX"

curl "${URL}/script.php?action=heartbeat&hostname=${HOSTNAME}&ipaddress=${IPADDR}"
