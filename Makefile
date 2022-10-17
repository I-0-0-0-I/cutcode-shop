COMPOSE_FILE = dev.yml

build:
	docker-compose -f $(COMPOSE_FILE) build
start:
	docker-compose -f $(COMPOSE_FILE) up -d
stop:
	docker-compose -f $(COMPOSE_FILE) down --remove-orphans
restart:
	make stop && make start
composer_install:
	docker-compose -f $(COMPOSE_FILE) exec app composer install
test:
	docker-compose -f test.yml exec app composer test
migrate:
	docker-compose -f $(COMPOSE_FILE) exec app php artisan migrate
static:
	docker-compose -f $(COMPOSE_FILE) exec app npm install \
	&& docker-compose -f $(COMPOSE_FILE) exec app npm run dev
init_dev:
	make composer_install \
	&& docker-compose -f $(COMPOSE_FILE) exec app composer app:dev:init
create_bucket:
	docker-compose -f $(COMPOSE_FILE) run minio_create_bucket
