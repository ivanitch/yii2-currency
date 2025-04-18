include .env

# MySQL
#MYSQL_DUMPS_DIR=data/db/dumps

all: help

build:
	@docker compose up -d --build

up:
	@docker compose up -d

stop:
	@docker compose stop

down:
	@docker compose down -v

restart:
	@docker compose restart

ps:
	@docker compose ps

logs:
	@docker compose logs -f

app:
	@docker exec -it ${APP_NAME}_php-fpm /bin/bash

help:
	@echo ""
	@echo "usage: make COMMAND\n"
	@echo "Commands:"
	@echo "- build      Start to build docker images in your docker-compose file."
	@echo "- up         Up your containers. (Like 'docker compose up -d')"
	@echo "- stop       Stopping all containers"
	@echo "- down       Down your containers. (Like 'docker compose down')"
	@echo "- restart    Restart all containers."
	@echo "- ps         List containers."
	@echo "- logs       Follow log output"
	@echo "- server     Enter your PHP-FPM container.\n"
