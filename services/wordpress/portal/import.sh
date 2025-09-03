#!/bin/bash

unzip -o /var/www/html/portal/uploads.zip -d /var/www/html/wp-content/
cd /var/www/html && wp db import /var/www/html/portal/wordpress.sql --allow-root