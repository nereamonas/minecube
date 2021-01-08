#!/bin/bash


#Prepararemos el docker-compose. Cambiamos los XXXX del fichero docker-compose_ejemplo.yml por el numero del puerto donde sé lanzará el nuevo servicio
cd static/scripts/  # porq al lanzar el php sino no está dentro de esta carpeta y no encuentra el docker-compose_ejemplo
echo "Creando servicio"
b="bbb$1"
sudo sed 's/XXXX/'\\$b'/g' docker-compose_ejemplo.yml > docker-compose.yml
sudo sed -i 's/bbb//g' docker-compose.yml 

#Ya tendremos el docker-compose.yml personalizado creado. Ahora lo ejecutamos

sudo docker-compose up -d

#lo paramos
n="n$1"
sudo docker stop $n

#sudo docker run -p 25565:25565 minecube/minecube 

#Como llamar al metodo: #./lanzarServicio.sh 25566
