up: docker-up
init: docker-down-clear docker-pull docker-build docker-up blog-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

blog-init: blog-composer-install blog-assets-install blog-wait-db blog-migrations blog-fixtures

blog-composer-install:
	docker-compose run --rm blog-php-cli composer install

blog-assets-install:
	docker-compose run --rm manager-node npm install
	docker-compose run --rm manager-node npm rebuild node-sass

blog-wait-db:
	until docker-compose exec -T blog-postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

blog-migrations:
	docker-compose run --rm blog-php-cli php bin/console doctrine:migrations:migrate --no-interaction

blog-fixtures:
	docker-compose run --rm blog-php-cli php bin/console doctrine:fixtures:load --no-interaction

blog-assets-dev:
	docker-compose run --rm blog-node npm run dev