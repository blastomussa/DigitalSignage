#!/bin/bash

err=`sudo systemctl status kiosk.service | grep -c running`

if [ "$err" -eq '0' ]
then
	log_date=`date`
	echo "Kiosk error restarted on ${log_date}" >> /home/pi/restart_log.txt
	sudo reboot
fi

exit 0
