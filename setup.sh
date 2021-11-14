#!/usr/bin/env bash

set -o pipefail

rand() {
  echo `cat /dev/urandom | env LC_ALL=C tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1`
}


if [ -f rtmpie.conf ]; then
  echo "The config file does already exist. If you want to proceed, please run \"rm rtmpie.conf\" first."
  exit 1
fi

wget -O docker-compose.yml https://raw.githubusercontent.com/ngrie/rtmpie/main/docker/docker-compose.prod.yaml

while [ -z "${RTMPIE_HOSTNAME}" ]; do
  read -p "Enter the hostname you want to use for RTMPie (e.g. demo.rtmpie.de): " -e RTMPIE_HOSTNAME
done

read -r -p  "Do you want to enable SSL (access the application using https:// instead of http://) (recommended)? [Y/n] " response
case $response in
  [nN][oO]|[nN])
    RTMPIE_HTTP_SCHEME=http
    RTMPIE_CADDY_SERVER_NAME="${RTMPIE_HOSTNAME}:80"
    ;;
  *)
    RTMPIE_HTTP_SCHEME=https
    RTMPIE_CADDY_SERVER_NAME="${RTMPIE_HOSTNAME}"
  ;;
esac

RTMPIE_APP_SECRET=$(rand)
RTMPIE_MERCURE_JWT_KEY=$(rand)
RTMPIE_DATABASE_PASSWORD=$(rand)

cat << EOF > rtmpie.conf
RTMPIE_HOSTNAME=${RTMPIE_HOSTNAME}
RTMPIE_HTTP_SCHEME=${RTMPIE_HTTP_SCHEME}
RTMPIE_CADDY_SERVER_NAME=${RTMPIE_CADDY_SERVER_NAME}

# Auto-generated credentials for internal use
RTMPIE_APP_SECRET=${RTMPIE_APP_SECRET}
RTMPIE_MERCURE_JWT_KEY=${RTMPIE_MERCURE_JWT_KEY}
RTMPIE_DATABASE_PASSWORD=${RTMPIE_DATABASE_PASSWORD}

EOF

ln -s rtmpie.conf .env
