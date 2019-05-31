#!/bin/bash

docker-compose build

docker-compose -f docker-compose.yml up -d


sleep 4;

docker exec blog composer update

docker exec blog php commande/createsql.php

echo
echo "#-----------------------"
echo "# Please check your browser"
echo "#-----------------------"
echo

exit 0