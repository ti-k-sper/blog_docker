#!/bin/bash

docker-compose stop

sleep 3;

docker-compose rm -f

echo
echo "#-----------------------"
echo "# Everithing it's stopped, and deleted"
echo "#-----------------------"
echo


exit 0