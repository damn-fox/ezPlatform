.PHONY: help
.DEFAULT_GOAL := help
start: #docker-compose up -d
	docker-compose up -d
stop: #docker-compose stop
	docker-compose stop
sh: # entra nel container fiaso_app
	docker exec -e COLUMNS="`tput cols`" -e LINES="`tput lines`" -it damnfoxezplatform_engine_1 /bin/bash
help: # make help
	@cat Makefile | grep -E "^[-a-zA-Z/]+:.*#" | grep -E --color=auto "^[-a-zA-Z/]+:"