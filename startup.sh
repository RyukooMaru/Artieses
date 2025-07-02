#!/bin/bash

# Salin file konfigurasi PHP kustom
cp /home/site/wwwroot/custom.ini /usr/local/etc/php/conf.d/

# --- TAMBAHKAN BAGIAN INI ---
# Ubah konfigurasi Nginx untuk menunjuk ke /public
sed -i 's|/home/site/wwwroot|/home/site/wwwroot/public|g' /etc/nginx/sites-available/default
# --- AKHIR BAGIAN TAMBAHAN ---

# Jalankan skrip startup bawaan Azure
/opt/startup/startup.sh
