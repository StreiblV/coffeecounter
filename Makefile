.PHONY: db
db:
	docker kill database || true
	docker rm database || true
	docker run \
		-d \
		--name database \
		-p 3306:3306 \
		-e MYSQL_ROOT_PASSWORD=password \
		-e MYSQL_DATABASE=coffeecounter \
		-e MYSQL_USER=coffeecounter \
		-e MYSQL_PASSWORD=coffeecounter \
		mysql:latest

