#!/bin/bash
yes | apt-get update
yes | apt-get upgrade

#install docker
yes | apt-get install apt-transport-https ca-certificates curl gnupg2 software-properties-common
yes | curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -
yes | add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/debian $(lsb_release -cs) stable"
yes | apt-get update
yes | apt-get install docker-ce
docker build -t mineserver /master
docker run -p 25565:25565 mineserver



