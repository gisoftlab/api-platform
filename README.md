* Instalation application 
  1.) docker-compose pull
  2.) COMPOSE_HTTP_TIME=300 docker-compose up -d
  3.) docker-compose exec php bin/console doctrine:schema:update --force
  4.) docker-compose exec php bin/console doctrine:fixtures:load
  
  
  // access to database
  docker-compose exec db psql -U api-platform api
  // quit
  \q
  
* check - Port is already used   
  sudo netstat -p -nlp | grep 80
