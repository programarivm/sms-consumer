<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
    getenv('RABBITMQ_HOST'),
    getenv('RABBITMQ_PORT'),
    getenv('RABBITMQ_USER'),
    getenv('RABBITMQ_PASSWORD')
);
$channel = $connection->channel();

// TODO

// ...
