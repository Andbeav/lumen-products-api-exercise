#!/bin/sh

for i in $(seq 1 20)
do [ $i -gt 1 ] && sleep 3
mysql -udefault -psecret -hdb -e 'show tables;' default && s=0 && break || s=$?
done
(exit $?)
