## Add dockerized commands to path
PATH := $(PATH):tools

docker-build:
	docker build -t timeweb/phpstan-enum .

install:
	composer install

test:
	php vendor/bin/phpunit

test-coverage:
	phpdbg -qrr vendor/bin/phpunit -d memory_limit=512m --coverage-html=_coverage --coverage-text
