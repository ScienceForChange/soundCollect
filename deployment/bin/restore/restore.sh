#!/bin/bash

set -e

BACKUP_FILENAME=$1
MYSQL_USER=$2
MYSQL_PASSWORD=$3

PROJECT_DIR="/usr/src"
BACKUP_DIR=$PROJECT_DIR"/usr/src/storage/app/backup"

docker-compose exec api aws s3 cp s3://devops-with-laravel-backups/$BACKUP_FILENAME $PROJECT_DIR"/storage/app/backup.zip"
docker-compose exec api unzip -o $PROJECT_DIR"/storage/app/backup.zip" -d $BACKUP_DIR

docker-compose exec api php $PROJECT_DIR"/artisan" down

# Restore database
docker-compose exec api mysql -u$MYSQL_USER -p$MYSQL_PASSWORD posts < $BACKUP_DIR"/db-dumps/mysql-posts.sql"

# Copy the current files
docker-compose exec api mv $PROJECT_DIR"/.env" $PROJECT_DIR"/.env_before_restore"
docker-compose exec api mv $PROJECT_DIR"/storage/app/public" $PROJECT_DIR"/storage/app/public_before_restore"

# Restore old files from backup
docker-compose exec api mv $BACKUP_DIR"/"$PROJECT_DIR"/.env" $PROJECT_DIR"/.env"
docker-compose exec api mv $BACKUP_DIR"/"$PROJECT_DIR"/storage/app/public" $PROJECT_DIR"/storage/app/public"

docker-compose exec api php $PROJECT_DIR"/artisan" storage:link
docker-compose exec api php $PROJECT_DIR"/artisan" optimize:clear

docker-compose exec api php $PROJECT_DIR"/artisan" up
