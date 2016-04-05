vendor/autoload.php:
	composer install --no-interaction --prefer-source

.PHONY: sniff
sniff: vendor/autoload.php
	vendor/bin/phpcs --standard=PSR2 $(ls | grep -v vendor) -n

.PHONY: test
test: vendor/autoload.php
	vendor/bin/phpunit --verbose