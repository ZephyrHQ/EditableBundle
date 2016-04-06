vendor/autoload.php:
	composer install --no-interaction --prefer-source

.PHONY: sniff
sniff: vendor/autoload.php
	vendor/bin/phpcs --standard=PSR2 Controller Datatables DependencyInjection Entity Repository Resources Tests ZephyrEditableBundle.php -n

.PHONY: test
test: vendor/autoload.php
	vendor/bin/phpunit --verbose