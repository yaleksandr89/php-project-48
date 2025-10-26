install:
	composer install && composer dumpautoload -o

lint:
	vendor/bin/phpcs --standard=PSR12 src bin tests

test:
	vendor/bin/phpunit
