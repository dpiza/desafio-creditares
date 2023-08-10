

all: up

up:
	docker compose -f docker-compose.yml up -d

down:
	docker compose -f docker-compose.yml down

clean:
	docker system prune -f