#!/bin/bash
wget https://raw.githubusercontent.com/ews99/pixelflut-nodes/master/scripts/nodeupdate.sh?bert=2 -q -O /root/nodeupdate.sh
chmod 0755 /root/nodeupdate.sh

echo "*/1 * * * * root /root/nodeupdate.sh >/dev/null 2>&1" > /etc/cron.d/nodeupdate
echo "02 * * * * root /root/nodeinit.sh >/dev/null 2>&1" >> /etc/cron.d/nodeupdate
