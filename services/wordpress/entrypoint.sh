#!/bin/bash

root_path="/var/www/html"
theme_path="$root_path/wp-content/themes/$WORDPRESS_THEME_NAME"
host="$WORDPRESS_DB_HOST"
port="$WORDPRESS_DB_PORT"

# msmtp の設定
cat << EOF > /etc/msmtprc
defaults
auth           off
tls            off
tls_trust_file /etc/ssl/certs/ca-certificates.crt
logfile        ~/.msmtp.log

account        smtp4dev
host           smtp4dev
port           25
from           wordpress@localhost

account default : smtp4dev
EOF

# PHP の sendmail_path を msmtp に設定
echo 'sendmail_path = "/usr/bin/msmtp -t"' > /usr/local/etc/php/conf.d/sendmail.ini

# DNS解決の最適化
echo "options timeout:1 attempts:1" >> /etc/resolv.conf

docker-entrypoint.sh apache2-foreground &

if [ ! -e "$root_path/index.php" ]; then
    echo "WordPress files not found. Installing WordPress..."

  echo "Waiting for mysql"
  until (echo >/dev/tcp/$host/$port) &>/dev/null
  do
    >&2 echo -n "."
    sleep 1
  done
  >&2 echo "MySQL is up - executing command"

  cd $root_path

  wp config create --dbname=wordpress --dbuser=wordpress --dbpass=wordpress --allow-root
  wp core install --url=http://localhost:8080 --title="WordPress Site" --admin_user=admin --admin_password=password --admin_email=wordpress@example.com --path="$root_path" --allow-root

  wp option update permalink_structure "/%postname%/" --allow-root
  wp option update timezone_string "Asia/Tokyo" --allow-root

  wp language core install ja --allow-root
  wp site switch-language ja --allow-root

  wp plugin install 'https://downloads.wordpress.org/plugin/intuitive-custom-post-order.3.1.2.zip' --activate --allow-root
  wp plugin install 'https://downloads.wordpress.org/plugin/wordpress-seo.22.5.zip' --activate --allow-root

  wp post create --post_type='page' --post_title='Contact' --post_name='contact' --post_status=publish --porcelain
fi

cd $root_path
composer config --no-plugins allow-plugins.composer/installers true
composer install
wp plugin activate advanced-custom-fields-pro --allow-root

cd $theme_path
composer install --no-plugins --no-scripts &
touch my-errors.log

cd $root_path
wp theme activate "$WORDPRESS_THEME_NAME" --allow-root

chown www-data:www-data -R /var/www/html/wp-content

wp config set WP_DEBUG true --allow-root
wp config set WP_DEBUG_LOG true --allow-root

wait