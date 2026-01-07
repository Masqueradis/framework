DOCKER_COMPOSE=docker compose -f docker/docker-compose.yml --env-file docker/.env

.PHONY: start stop install terminal ps restart

up:
	${DOCKER_COMPOSE} up -d 

down:
	${DOCKER_COMPOSE} down 

restart:
	${DOCKER_COMPOSE} down 
	${DOCKER_COMPOSE} up -d

build:
	${DOCKER_COMPOSE} build

bash:
	${DOCKER_COMPOSE} exec php bash

ps:
	${DOCKER_COMPOSE} ps 
