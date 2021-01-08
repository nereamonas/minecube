#!/bin/bash
source /serverFiles/utils.sh
# varip: tiene la ip de la maquina
#conseguir ip
varip=$(printf $(ip r | awk '{print $9;}'))

#asignar ip del host
repline server-ip= server-ip=$varip $serProp
