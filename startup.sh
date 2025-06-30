#!/bin/bash

echo "Starting custom nginx configuration..."
# Salin file konfigurasi kustom kita ke lokasi konfigurasi Nginx yang aktif
cp /home/site/wwwroot/nginx/default /etc/nginx/sites-enabled/default

# Muat ulang Nginx untuk menerapkan konfigurasi baru
service nginx reload
echo "Nginx reloaded with custom configuration."