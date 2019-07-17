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

blog-init: blog-composer-install blog-assets-install

blog-composer-install:
	docker-compose run --rm blog-php-cli composer install

blog-assets-install:
	docker-compose run --rm blog-node npm install
	docker-compose run --rm blog-node npm rebuild node-sass