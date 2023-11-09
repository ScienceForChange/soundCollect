#!/bin/bash

set -e

SSH_USER=$1
SERVER_IP=$2
IMAGE_TAG=$3

scp -C -o StrictHostKeyChecking=no -i $HOME/.ssh/id_ed25519 $HOME/.ssh/id_ed25519 $SSH_USER@$SERVER_IP:~/.ssh/id_rsa

scp -C -o StrictHostKeyChecking=no -i $HOME/.ssh/id_ed25519 ./rollback.sh $SSH_USER@$SERVER_IP:./rollback.sh
ssh -tt -o StrictHostKeyChecking=no -i $HOME/.ssh/id_ed25519 $SSH_USER@$SERVER_IP "chmod +x ./rollback.sh && ./rollback.sh $IMAGE_TAG"
