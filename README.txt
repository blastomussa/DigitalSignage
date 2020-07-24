Digital Signage App
Author: blastomussa

APACHE SETUP
  set up apache web server on always-on server run as service on reboot
    edit /etc/apache2/sites-available/httpd.conf (linux)
      load module PHP7 or PHP5
      configure to listen to port 80/443 over server's IP address
      change DocumentRoot to folder with html/css/resources *optional


There's more than one way to deploy a pi kiosk full version is a little bloated
-->try Lite https://blockdev.io/raspberry-pi-2-and-3-chromium-in-kiosk-mode/
PI SETUP
  drop ssh and wpa_supplicant.conf with updated wifi creds into boot partition

  change password with passwd command....default:raspberry

  change pi hostname to PiKiosk{#}
    sudo vi /etc/hosts
    sudo vi /etc/hostname
    sudo reboot

  sudo apt-get update && sudo apt-get dist-upgrade

  purge/remove unnecessary software
    sudo apt-get remove --purge wolfram-engine scratch nuscratch sonic-pi idle3 smartsim java-common minecraft-pi python-minecraftpi python3-minecraftpi libreoffice python3-thonny geany claws-mail bluej greenfoot

  sudo apt-get autoremove && sudo apt-get clean

  sudo apt-get install xdotool unclutter sed

  raspi-config
    Boot Options -> B1 Desktop / CLI -> B4 Desktop Autologin
    force 720p hmdi output
    optional enable/disable vnc

  create /home/pi/kiosk.sh
    change IP address to IP of web app

  edit /lib/systemd/system/kiosk.service
    [Unit]
    Description=Chromium Kiosk
    Wants=graphical.target
    After=graphical.target

    [Service]
    Environment=DISPLAY=:0.0
    Environment=XAUTHORITY=/home/pi/.Xauthority
    Type=simple
    ExecStart=/bin/bash /home/pi/kiosk.sh
    Restart=on-abort
    User=pi
    Group=pi

    [Install]
    WantedBy=graphical.target

  edit /etc/xdg/lxsession/LXDE-pi/autostart + change blank screen w raspi-config
    @xscreensaver -no-splash
    @xset s noblank
    @xset s off
    @xset -dpms

  sudo systemctl enable kiosk.service
  sudo systemctl start kiosk.service

  move refresh.sh and error_check.sh into pi and set up crontabs for each
  chmod u+x refresh.sh error_check.sh kiosk.sh

  create /etc/chromium-browser/customizations/01-disable-update-check
    CHROMIUM_FLAGS="${CHROMIUM_FLAGS} --check-for-update-interval=31536000"

HOW TO UPDATE WEB APP
  ssh into machine thats running apache

  change web page IP in /home/pi/kiosk.sh

  the admin portal can change the slide show, marquee and add management users

  cd to the DocumentRoot folder which holds the web apps resources

  open index.html in editor

    updated weather widgets can be put in the weather div

    updated calendars can be put in the calendar div...change height + width to 100% and put "border-radius:20px;" in the style attribute of the iframe
