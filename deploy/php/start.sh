#!/bin/sh
#configuracion de zona horaria
if [ "$CONTAINER_TIMEZONE" ]; then
    apk add tzdata
    cp /usr/share/zoneinfo/${CONTAINER_TIMEZONE} /etc/localtime && \
        echo "${CONTAINER_TIMEZONE}" >  /etc/timezone && \
        echo "Cambió zona horaria del contenedor: $CONTAINER_TIMEZONE"
fi


apache2 -D FOREGROUND
