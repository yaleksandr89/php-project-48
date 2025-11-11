install:
	composer install

refresh:
	composer install && composer dump-autoload

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin

lint-fix:
	composer exec phpcbf -- --standard=PSR12 src bin tests

test:
	composer exec phpunit -- --colors=always
