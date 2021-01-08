from debian
RUN mkdir /serverFiles
RUN chmod 777 /serverFiles
COPY /serverFiles/ /serverFiles
RUN apt-get -qq update
RUN apt-get -qq -y install git build-essential
RUN apt-get -qq -y install openjdk-11-jre-headless
RUN chmod 777 /serverFiles/initConf.sh /serverFiles/serverProperties.sh /serverFiles/utils.sh /serverFiles/updateIP.sh # preparar scripts para que sean ejecutables
WORKDIR /serverFiles/exect
RUN java -Xmx2048M -Xms1024M -jar paper-194.jar # generar mapas y ficheros de server
RUN /serverFiles/initConf.sh
CMD bash /serverFiles/updateIP.sh
CMD java -Xmx2048M -Xms1024M -jar paper-194.jar # abrir servidor
