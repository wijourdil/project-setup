#!Make

# Setup project
setup:
	composer install

# Run phpunit with coverage
coverage:
	./vendor/bin/phpunit --coverage-html code_coverage

# Run the whole test suite (security checker + phpcs + phpstan + phpunit without coverage)
test:
	symfony security:check;
	./vendor/bin/phpcs
	./vendor/bin/phpstan analyse --memory-limit=2G
	./vendor/bin/phpunit --no-coverage
