install:
	composer install

refresh:
	composer install && composer dump-autoload

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 --error-severity=1 --warning-severity=1 src bin tests

test:
	composer exec phpunit -- --colors=always

test-coverage:
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml

fix:
	composer exec phpcbf -- --standard=PSR12 src bin tests
