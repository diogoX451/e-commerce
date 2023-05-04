
BASEDIR=${PWD}/$(dirname "$0")
ecommerce.api
echo "--------- CRIANDO NETWORK ----------"
sudo docker network create ecommerce_net

sudo docker rm -f ecommerce.api
sudo docker rm -f ecommerce.db

echo "--------- BUILDANDO A IMAGEM ----------"
sudo docker build -t ecommerce.api ${BASEDIR}


echo "--------- CRIANDO CONTAINER ----------"
sudo docker run --restart=always --name ecommerce.api -idt --network ecommerce_net -p 16:16  -v ${BASEDIR}/..:/var/www/html ecommerce.api
sudo docker run --restart=always --name ecommerce.db -idt --network ecommerce_net -e POSTGRES_PASSWORD=admin -e PGDATA=/var/lib/postgresql/data/pgecommerce -v ${BASEDIR}/../../db:/var/lib/postgresql/data postgres
echo "--------- CRIANDO HOSTS ----------"
if grep "172.18.0.2" /etc/hosts> /dev/null
then
    echo "--------- HOST JÁ EXISTE ----------"
    echo "--------- ATUALIZANDO PROJETO ----------"
    sudo docker exec ecommerce.api composer install
    sudo docker exec ecommerce.api php artisan migrate
    echo "LINK:  http://ecommerce.api"
    exit
fi
echo "--------- HOST CRIADA ----------"
sudo echo "172.18.0.2 ecommerce.api" | sudo tee -a /etc/hosts
echo "--------- ATUALIZANDO PROJETO ----------"
sudo docker exec ecommerce.api composer install
sudo docker exec ecommerce.api php artisan migrate
echo "--------- LINK DO PROJETO ----------"
echo "LINK:  http://ecommerce.api"