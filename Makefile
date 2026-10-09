.PHONY: setup up down test lint format generate-api logs

setup:
	test -f apps/api/.env || cp apps/api/.env.example apps/api/.env
	test -f apps/web/.env || cp apps/web/.env.example apps/web/.env
	docker compose build
	docker compose up -d postgres mailpit
	docker compose run --rm api php artisan key:generate
	docker compose run --rm api php artisan migrate

up:
	docker compose up -d

down:
	docker compose down

test:
	docker compose run --rm -e DB_DATABASE=comentaro_test api composer test
	docker compose run --rm web npm run test

lint:
	docker compose run --rm api composer lint
	docker compose run --rm api composer analyse
	docker compose run --rm web npm run check

format:
	docker compose run --rm api composer format
	docker compose run --rm web npm run lint -- --fix

generate-api:
	docker compose run --rm web npm run api:generate

logs:
	docker compose logs -f api worker scheduler web
