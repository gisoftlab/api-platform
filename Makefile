dev:
    @docker-compose down && \
        docker-compose build --pull --no-cache && \
        docker-compose \
            -f docker-compose.yml \
        up -d --remove-orphans

stop:
    @docker-compose stop

down:
    @docker-compose down

up:
    sudo COMPOSE_HTTP_TIME=300 @docker-compose up -d
