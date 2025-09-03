#!/bin/bash

portal_root=/var/www/html/portal
wp db export "$portal_root/wordpress.sql" --allow-root
cd /var/www/html/wp-content/ && zip -r /var/www/html/portal/uploads.zip uploads