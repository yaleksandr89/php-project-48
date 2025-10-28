install:
	composer install

refresh:
	composer install && composer dump-autoload

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin

test:
	composer exec phpunit -- --colors=always

test-coverage:
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml
