install:
	composer install

refresh:
	composer install && composer dump-autoload

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 --error-severity=1 --warning-severity=1 src bin tests

lint-fix:
	composer exec phpcbf -- --standard=PSR12 src bin tests

test:
	composer exec phpunit -- --colors=always

gendiff-nested:
	./bin/gendiff tests/Fixtures/nested_file1.json tests/Fixtures/nested_file2.json