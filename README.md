# Watchdog Service


### Getting started

Build and start the services:

```shell
make env-setup build up
```

Install the application:

```shell
make composer-install generate-app-key db-refresh
```

Run the application

```shell
docker-compose up -d --build
```
