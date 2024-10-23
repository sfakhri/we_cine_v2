# --------------------------------#
# Makefile for the "make" command
# --------------------------------#

# ----- Colors -----
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

# ----- Programs -----
COMPOSER = composer
PHP = php
SYMFONY = symfony
SYMFONY_CONSOLE = $(PHP) bin/console
PHP_UNIT = $(PHP) bin/phpunit
NPM = npm
DOCKER_DEV_FREELAND = sudo docker-compose -f docker-compose.dev.yml
DOCKER_DEV = sudo docker-compose

## ----- System -----
cl: ## clear
	clear

las: ## las
	ls -la

## ----- Docker dev -----
docker-run: ## docker run
	@$(call GREEN, "Docker run!")
	$(DOCKER_DEV) up -d

docker-ps: ## docker ps
	@$(call GREEN, "Docker ps!")
	$(DOCKER_DEV) ps

docker-build: ## docker build
	@$(call GREEN, "Docker build!")
	$(DOCKER_DEV) up --force-recreate --build -d

docker-stop: ## docker stop
	@$(call GREEN, "Docker stop!")
	$(DOCKER_DEV) stop

docker-exec: ## docker exec
	@$(call GREEN, "Docker exec!")
	$(DOCKER_DEV) exec apache bash

docker-cpi: ## docker exec
	@$(call GREEN, "Docker exec compposer install!")
	$(DOCKER_DEV) exec apache composer install

docker-restart: ## docker restart
	@$(call GREEN, "Docker restart!")
	$(DOCKER_DEV) restart

docker-down: ## docker down
	@$(call GREEN, "Docker down!")
	$(DOCKER_DEV) down

## ----- Project -----
init: ## Initialize the project
	$(MAKE) composer-install

## ----- Composer -----
composer-install: ## Install the dependencies
	@$(call GREEN, "Installing dependencies...")
	$(COMPOSER) install

composer-update: ## Update the dependencies
	@$(call GREEN, "Updating dependencies...")
	$(COMPOSER) update

## ----- NPM -----
npm-install: ## Install the dependencies
	@$(call GREEN, "Installing dependencies...")
	$(NPM) install
	$(MAKE) npm-build

npm-build: ## Build the assets
	@$(call GREEN, "Building assets...")
	$(NPM) run build

## ----- Symfony -----
start: ## Start the project
	@$(call GREEN, "Starting the project...")
	$(SYMFONY) server:start
	@$(call GREEN, "Project started! You can now access it at http://127.0.0.1:8000")

stop: ## Stop the project
	@$(call GREEN, "Stopping the project...")
	$(SYMFONY_CONSOLE) server:stop
	@$(call GREEN, "Project stopped!")

database-create: ## Create the database
	@$(call GREEN, "Creating database...")
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists

database-drop: ## Drop the database
	@$(call GREEN, "Dropping database...")
	$(SYMFONY_CONSOLE) doctrine:database:drop --force --if-exists

database-migrate: ## Migrate the database
	@$(call GREEN, "Migrating database...")
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction

database-rollback: ## Rollback the database
	@$(call GREEN, "Rolling back database...")
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate prev --no-interaction

database-fixtures: ## Load the fixtures
	@$(call GREEN, "Loading fixtures...")
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction

database-init: ## Initialize the database
	@$(call GREEN, "Initializing database...")
	$(MAKE) database-drop
	$(MAKE) database-create
	$(MAKE) database-migrate
	$(MAKE) database-fixtures

cache-clear: # Clear the cache
	@$(call GREEN, "Clearing cache...")
	$(SYMFONY_CONSOLE) cache:clear
## ----- Tests -----
tests: ## Run the tests
	@$(call GREEN, "Running tests...")
	$(MAKE) database-init-test
	$(PHP_UNIT)

database-init-test: ## Init database for tests
	@$(call GREEN, "Creating the database for tests...")
	$(SYMFONY_CONSOLE) d:d:d --force --if-exists --env=test
	$(SYMFONY_CONSOLE) d:d:c --env=test --if-not-exists
	$(SYMFONY_CONSOLE) d:m:m --no-interaction --env=test
	$(SYMFONY_CONSOLE) d:f:l --no-interaction --env=test

## ----- Help -----
help: ## Display this help
	@$(call GREEN, "Available commands:")
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'