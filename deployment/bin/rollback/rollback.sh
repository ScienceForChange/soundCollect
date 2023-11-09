#!/bin/bash

IMAGE_TAG=$1

cd /usr/src

sed -i "/IMAGE_TAG/c\IMAGE_TAG=$IMAGE_TAG" /usr/src/.env

sudo docker-compose -f docker-compose.prod.yml down
sudo docker-compose -f docker-compose.prod.yml up -d --remove-orphans
