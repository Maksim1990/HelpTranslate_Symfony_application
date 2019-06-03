**HOT TO INSTALL APP**
--
     
* *Copy ``.env`` environment config file and set all required settings in it:*

    cp .env.dist .env
    cp ./app/config/parameters.yml.dist ./app/config/parameters.yml
     
* *Start app and build required Docker containers:*

        docker-compose up -d
      
* *Install all composer dependencies:*

        docker exec -it helptranslate_php composer install

* *Run all required migrations:*

        docker exec -it helptranslate_php php bin/console doctrine:mig:mig
  
      
* *Change permission for 'storage' folder:*
    
        docker exec -it helptranslate_php  chmod +x ./services/docker/set_var_read_write_permissions.sh
        docker exec -it helptranslate_php  ./services/docker/set_var_read_write_permissions.sh

App is available on ``8306`` port
--
    http://127.0.0.1:8306