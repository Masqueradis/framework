DOCKER_COMPOSE=docker compose -f docker/docker-compose.yml --env-file docker/.env

.PHONY: start stop install terminal ps

start:
	${DOCKER_COMPOSE} up -d 

stop:
	${DOCKER_COMPOSE} down 

install:
	${DOCKER_COMPOSE} build

terminal:
	${DOCKER_COMPOSE} exec php bash

ps:
	${DOCKER_COMPOSE} ps 
