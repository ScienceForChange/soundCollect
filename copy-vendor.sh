#!/bin/sh

API_ID=$(docker ps --filter "name=api" --format "{{.ID}}")
WORKER_ID=$(docker ps --filter "name=worker" --format "{{.ID}}")
SCHEDULER_ID=$(docker ps --filter "name=scheduler" --format "{{.ID}}")

docker cp $API_ID:/usr/src/vendor ./api
docker cp ./api/vendor $WORKER_ID:/usr/src
docker cp ./api/vendor $SCHEDULER_ID:/usr/src
