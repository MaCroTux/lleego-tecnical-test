IMAGE_NAME=composer-xdebug
IMAGE_VERSION=1.0.0

DOCKER_COMMAND=docker run --rm -it -v ${PWD}:/var/www
DOCKER_EXEC=${DOCKER_COMMAND} $(IMAGE_NAME):$(IMAGE_VERSION)
DOCKER_COMPOSE_EXEC=${DOCKER_EXEC} composer

CODE_ANALYZER=docker run -v ${PWD}:/code --rm ghcr.io/phpstan/phpstan:latest-php8.1 analyse -a /code/vendor/autoload.php
CODE_ANALYZER_WITH_PATH=${CODE_ANALYZER} /code/tests /code/src

help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

build: # Build the docker image
	@if docker images $(IMAGE_NAME):$(IMAGE_VERSION) | awk '{ print $$2 }' | grep -q -F $(IMAGE_VERSION); 	\
	then 																									\
		echo "The image $(IMAGE_NAME):$(IMAGE_VERSION) already exist."; 									\
	else 																									\
		docker build -t $(IMAGE_NAME):$(IMAGE_VERSION) .; 													\
	fi

composer_install: build
	@if [ ! -d "./vendor" ]; then 				 \
  		${DOCKER_COMPOSE_EXEC} install; \
	fi

composer_require: build
	${DOCKER_COMPOSE_EXEC} require ${ARGS};

tests: build composer_install # Lanza la suits de test con cobertura
	${CODE_ANALYZER_WITH_PATH} --level 5
	${DOCKER_EXEC} bash -c "XDEBUG_MODE=coverage bin/phpunit --coverage-html coverage"

up: # Levanta el proyecto
	symfony server:start --no-tls

lleego_avail_command: build # Ejecuta el comando de disponibilidad de Lleego
	${DOCKER_EXEC} bin/console lleego:avail ${ARGS}