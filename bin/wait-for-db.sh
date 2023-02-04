#!/bin/sh

for i in $(seq 1 20)
do [ $i -gt 1 ] && sleep 3
mysql -u"$DB_USERNAME" -p"$DB_PASSWORD" -h"$DB_HOST" -e 'show tables;' "$DB_DATABASE" && s=0 && break || s=$?
done
(exit $?)
