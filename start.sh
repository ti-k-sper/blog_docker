#!/bin/bash

docker-compose build

docker-compose -f docker-compose.yml up -d

echo
echo "#-----------------------"
echo "# Please check your browser"
echo "#-----------------------"
echo

exit 0