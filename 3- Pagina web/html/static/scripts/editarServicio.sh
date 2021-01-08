#!/bin/bash
#$1 -> gamemode
#$2 -> maxPlayers
#$3 -> spawnProtect
#$4 -> flight
#$5 -> puerto
#$6 -> estado


id="n$5"


if [[ $6 -eq "0" ]]; then
  #lo volvemos a arrancar para poder editarlo
  sudo docker start $id
fi

#primero hacemos el edit de gamemode:
gamemode="survival"
if [[ $1 -eq "2" ]]; then
    gamemode="creative"

elif [[ $1 -eq "3" ]]; then
  gamemode="adventure"

elif [[ $1 -eq "4" ]]; then
  gamemode="hardcore"

fi

sudo docker exec -i $id bash /serverFiles/serverProperties.sh gamemode $gamemode

#jugadores
sudo docker exec -i $id bash /serverFiles/serverProperties.sh maxPlayers $2

#spaw protection
sudo docker exec -i $id bash /serverFiles/serverProperties.sh spawnProtect $3

#fligth
fligth=false
if [[ $4 -eq "1" ]]; then
  fligth=true
fi
sudo docker exec -i $id bash /serverFiles/serverProperties.sh flight $fligth


#paramos el servicio
sudo docker stop $id

#si antes estaba arrancado, lo volvemos a arrancar, sino lo dejamos apagado
if [[ $6 -eq "1" ]]; then
  sudo docker start $id
fi



