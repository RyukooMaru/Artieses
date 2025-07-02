#!/bin/bash

# Salin file konfigurasi PHP kustom ke direktori yang benar
cp /home/site/wwwroot/custom.ini /usr/local/etc/php/conf.d/

# Jalankan skrip startup bawaan Azure setelahnya
/opt/startup/startup.sh
