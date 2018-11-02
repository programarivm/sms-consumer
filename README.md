## Introduction

> Objective: Build a web app that allows to send tweet-sized text messages.

This web app is split into three loosely coupled parts -- repos that can run in different environments -- according to a microservice architecture.

| Repo              | Description                                                                                |
|-------------------|--------------------------------------------------------------------------------------------|
| `sms`             | JWT-authenticated API and RabbitMQ producer                                                |
| `sms-spa`         | React SPA created with [`create-react-app`](https://github.com/facebook/create-react-app)  |
| `sms-consumer`    | RabbitMQ consumer. PHP script using [`php-amqplib`](https://github.com/php-amqplib/php-amqplib)                                                      |

> **Note**: The RabbitMQ producer does not share its codebase with the consumer.

More specifically, the Symfony producer in `sms` is built with `php-amqplib/rabbitmq-bundle`. However, the consumer in `sms-consumer` is a PHP script written with `php-amqplib` -- for the sake of simplicity we are considering not to use a framework in that repo.


SMS Consumer
============

This is the `sms-consumer` repo, a PHP script using `php-amqplib`.

### Start the Docker Services

    docker-compose up --build

### Install the Dependencies

    docker exec -it --user 1000:1000 sms_consumer_php_fpm composer install

### TODO

Write more documentation.