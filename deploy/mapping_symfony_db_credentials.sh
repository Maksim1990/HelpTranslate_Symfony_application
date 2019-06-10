#!/usr/bin/env bash

if [ $1 == "yes" ]; then
echo "Set DB connection with SHARED MySQL container";
    sed -e "s/\${APP_MYSQL_PORT}/${DEV_HTTPS_PORT}/g;
             s/\${APP_MYSQL_PASSWORD}/${DEV_SHARED_MYSQL_PASSWORD}/g;
             s/\${APP_MYSQL_DATABASE}/${DEV_MYSQL_DATABASE}/g;"  ./app/config/parameters.yml.deploy > ./app/config/parameters.yml
else
  echo "Set DB connection with LOCAL MySQL container";
      sed -e "s/\${APP_MYSQL_PORT}/${DEV_MYSQL_PORT}/g;
             s/\${APP_MYSQL_PASSWORD}/${DEV_MYSQL_PASSWORD}/g;
             s/\${APP_MYSQL_DATABASE}/${DEV_MYSQL_DATABASE}/g;"  ./app/config/parameters.yml.deploy > ./app/config/parameters.yml
fi