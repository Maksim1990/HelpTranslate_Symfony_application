#!/usr/bin/env bash

sed -e "s/\${APP_HTTP_PORT}/${DEV_HTTP_PORT}/g;
             s/\${APP_HTTPS_PORT}/${DEV_HTTPS_PORT}/g;
             s/\${APP_REDIS_PORT}/${DEV_REDIS_PORT}/g;"  ./deploy/docker-compose.dev.tpl.yml > ./docker-compose.yml
sed -e "s/\${APP_MYSQL_PASSWORD}/${DEV_SHARED_MYSQL_PASSWORD}/g;
 s/\${APP_MYSQL_DATABASE}/${DEV_MYSQL_DATABASE}/g;"  ./deploy/.env.dist.deploy > ./deploy/.env.dist