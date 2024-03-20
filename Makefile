all: up

up:
	docker-compose up --detach

down:
	docker-compose down

restart: down up