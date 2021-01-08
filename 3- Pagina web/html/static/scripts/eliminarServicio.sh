#!/bin/bash
#$1 -> puerto

n="n$1"

#lo paramos. porq no se puede borrar uno que este activo.
sudo docker stop $n

sudo docker rm $n
