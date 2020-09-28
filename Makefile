# Global variables that we're using
APP_ENV=local
LARAVEL_ENV_SOURCE_FILE = .env.$(APP_ENV)
DOCKER_COMPOSE = docker-compose -f ./docker-compose.$(APP_ENV).yml
IS_DEVELOPMENT_ENV=1

HOST_UID := $(shell id -u)
HOST_GID := $(shell id -g)

SHOW_IP_COMMAND = docker inspect -f "{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}" $(shell docker ps -qf name="notes")
SHOW_CONTAINER_LOG_COMMAND = docker logs $(CONTAINER_NAME)


WARNING_HOST = @printf "\033[31mThis command cannot be run inside docker container!\033[39m\n"
WARNING_ENVIRONMENT = @printf "\033[31mThis command must be run only development environment!\033[39m\n"
WARNING_DOCKER = @printf "\033[31mThis command must be run inside docker container!\nUse 'make shell' command to get shell inside container.\033[39m\n"

.DEFAULT_GOAL := help
.PHONY: help

help: setup-env
	@grep -E '^[a-zA-Z-]+:.*?## .*$$' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "[32m%-27s[0m %s\n", $$1, $$2}'

ifneq ($(APP_ENV), local)
	IS_DEVELOPMENT_ENV=0
endif

setup-env:
ifeq ("$(wildcard ./$(LARAVEL_ENV_SOURCE_FILE))","")
	@echo File $(LARAVEL_ENV_SOURCE_FILE) does not exist
	exit 1
else
	@cp $(LARAVEL_ENV_SOURCE_FILE) .env
endif

start: setup-env ## Start application
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(DOCKER_COMPOSE) up $(MODE)
endif

start-build: setup-env ## Start application and build containers
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(DOCKER_COMPOSE) up --build $(MODE)
endif

stop: ## Stop application containers
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(DOCKER_COMPOSE) down
endif

shell: ## Get bash inside PHP container
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(DOCKER_COMPOSE) exec php bash
endif

npm: ## Get npm console inside NODE container
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(DOCKER_COMPOSE) exec node bash
endif

show-status: ## Show application containers status
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(DOCKER_COMPOSE) ps
endif

show-container-log: ## Show application container log. (ex: make show-container-log php)
ifeq ($(INSIDE_DOCKER), 1)
	$(WARNING_HOST)
	exit 1
else
	@HOST_UID=$(HOST_UID) HOST_GID=$(HOST_GID) $(SHOW_CONTAINER_LOG_COMMAND)
endif

ifeq (show-container-log,$(firstword $(MAKECMDGOALS)))
	CONTAINER_NAME := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
	$(eval $(CONTAINER_NAME):;@:)
endif

show-application-log: ## Show application log
	@grep -inE '^\[202.*\]' storage/logs/laravel.log | awk '{print "\033[32m"$$0" \033[0m\n"}'

cleanup-database: ## Cleanup database: drop all data, re-run migrations and seeders
ifeq ($(IS_DEVELOPMENT_ENV), 1)
	@php ./artisan db:wipe
	@php ./artisan migrate:refresh --seed
else
	$(WARNING_ENVIRONMENT)
	exit 1
endif

setup-git-hooks: ## Setup clients git hooks (only development env)
ifeq ($(IS_DEVELOPMENT_ENV), 1)
	@cp ./docker/local/git/commit-msg ./.git/hooks/commit-msg
	@chmod +x ./.git/hooks/commit-msg
	@cp ./docker/local/git/pre-commit ./.git/hooks/pre-commit
	@chmod +x ./.git/hooks/pre-commit
	@cp ./docker/local/git/pre-push ./.git/hooks/pre-push
	@chmod +x ./.git/hooks/pre-push
else
	$(WARNING_ENVIRONMENT)
	exit 1
endif


run-phpstan: ## Run PhpStan
ifeq ($(IS_DEVELOPMENT_ENV), 1)
	@php ./artisan cache:clear
	@php ./artisan config:clear
	@php ./artisan route:clear
	@php ./artisan view:clear
	@echo "\033[32mRunning PhpStan...\033[39m"
	@php ./vendor/bin/phpstan analyse -c ./phpstan.neon
else
	$(WARNING_ENVIRONMENT)
	exit 1
endif

run-phpcs: ## Run PhpCodeSniffer
ifeq ($(IS_DEVELOPMENT_ENV), 1)
	@echo "\033[32mRunning code sniffer...\033[39m\n"
	@php ./vendor/bin/phpcs --colors --standard=./phpcs_rulset.xml -p
else
	$(WARNING_ENVIRONMENT)
	exit 1
endif

run-tests: ## Run tests
ifeq ($(IS_DEVELOPMENT_ENV), 1)
	@echo "\033[32mRunning application tests...\033[39m\n"
	@php ./vendor/bin/phpunit
else
	$(WARNING_ENVIRONMENT)
	exit 1
endif
