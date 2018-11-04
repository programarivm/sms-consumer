## Introduction

<p align="center">
	<img src="https://github.com/programarivm/sms-consumer/blob/master/resources/cubes.jpg" />
</p>

> Objective: Build a web app that allows to send tweet-sized text messages.

This web app is split into four loosely coupled parts -- repos that can run in different environments -- according to a microservice architecture.

| Repo                                                                           | Description                                                                                |
|--------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------|
| [`programarivm/sms`](https://github.com/programarivm/sms)                      | JWT-authenticated API and RabbitMQ producer                                                |
| [`programarivm/sms-spa`](https://github.com/programarivm/sms-spa)              | React SPA created with [`create-react-app`](https://github.com/facebook/create-react-app)  |
| [`programarivm/sms-consumer`](https://github.com/programarivm/sms-consumer)    | RabbitMQ consumer                                                                          |
| [`programarivm/sms-twilio-webhook`](https://github.com/programarivm/sms-twilio-webook)  | Twilio's webhook to track the delivery status of the SMS messages                          |

# SMS Consumer

This is the `sms-consumer` repo, a PHP script using `php-amqplib`.

### Start the Docker Services

    docker-compose up --build

### Install the Dependencies

    docker exec -it --user 1000:1000 sms_consumer_php_fpm composer install

### Environment Setup

Copy and paste the following into your `.env` file:

    DATABASE_DRIVER=pdo_mysql
    DATABASE_HOST=172.27.0.5
    DATABASE_PORT=3306
    DATABASE_NAME=sms
    DATABASE_USER=root
    DATABASE_PASSWORD=password

    RABBITMQ_HOST=172.27.0.2
    RABBITMQ_PORT=5672
    RABBITMQ_USER=sms
    RABBITMQ_PASSWORD=password

    TWILIO_NUMBER=+447000000000
    TWILIO_SID=ACXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    TWILIO_TOKEN=your_auth_token

> **Note**: the database and the RabbitMQ values must be the same as in the `app/config/parameters.yml` file in the [`sms`](https://github.com/programarivm/sms) app. The Twilio values must be those ones of your Twilio account.

### Run the consumers

    php cli/consumer.php

### Contributions

Would you help make this library better? Contributions are welcome.

- Feel free to send a pull request
- Drop an email at info@programarivm.com with the subject "SMS Contributions"
- Leave me a comment on [Twitter](https://twitter.com/programarivm)
- Say hello on [Google+](https://plus.google.com/+Programarivm)

Many thanks.
