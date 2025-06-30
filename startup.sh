#!/bin/bash

echo "--- Custom Startup: Overwriting default Nginx site config... ---"

# Hanya menyalin file konfigurasi kustom kita untuk menimpa file default.
# Platform Azure akan menangani sisanya (memulai/me-reload nginx).
cp /home/site/wwwroot/nginx/default /etc/nginx/sites-enabled/default

echo "--- Custom Nginx config is in place. Handing over to platform entrypoint. ---"
