#!/bin/bash

set -e

SSH_KEY=$1

useradd -G www-data,root,sudo,docker -u 1000 -d /home/sfc sfc
mkdir -p /home/sfc/.ssh
touch /home/sfc/.ssh/authorized_keys
chown -R sfc:sfc /home/sfc
chown -R sfc:sfc /usr/src
chmod 700 /home/sfc/.ssh
chmod 644 /home/sfc/.ssh/authorized_keys
echo "$SSH_KEY" >> /home/sfc/.ssh/authorized_keys

echo "sfc ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers.d/sfc

# Install docker-compose
sudo curl -L "https://github.com/docker/compose/releases/download/v2.19.1/docker-compose-linux-x86_64" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose --version
