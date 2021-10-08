# Handbook upload large csv with rabbitmq

## Tested on Ubuntu 20.1

## Dependencies:
- Docker
- Docker-compose


## To check, follow these steps:
1) run ```docker-compose up -d --build```

2) install dependencies ```docker-compose exec -T php-fpm bash -c "composer install"```

3) copy /app/.env-example to /app/.env or create yourself

4) run migrations ```docker-compose exec -T php-fpm bash -c "php bin/console doctrine:migrations:migrate"```

5) create a mock-csv if needed (path: /app/files/mock-csv) ```docker-compose exec -T php-fpm bash -c "php bin/console app:create-testcsv"```

6) open http://0.0.0.0:15672/  rabbitmq gui login/password:(guest:guest)

7) init messenger for check ```docker-compose exec -T php-fpm bash -c "php bin/console messenger:consume async -vv"```

8) open route http://0.0.0.0/upload and load csv

9) we will get a synch report and asynch loading into the database with rabbitmq

TODO: add tests