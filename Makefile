enter:
	@docker-compose exec php sh

up:
	@docker-compose up -d && docker-compose exec php composer install

down:
	@docker-compose down

.PHONY: tests
tests:
	@docker-compose exec php vendor/bin/phpunit tests