<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Connection\AMQPStreamConnection;

$dotenv = new Dotenv(__DIR__.'/../');
$dotenv->load();

$connection = new AMQPStreamConnection(
    getenv('RABBITMQ_HOST'),
    getenv('RABBITMQ_PORT'),
    getenv('RABBITMQ_USER'),
    getenv('RABBITMQ_PASSWORD')
);
$channel = $connection->channel();

$channel->exchange_declare('send_sms', 'direct', true, false, false);

$channel->queue_declare('send_sms_queue', false, true, false, false);

$channel->queue_bind('send_sms_queue', 'send_sms');

echo " [*] Waiting for SMS messasges. To exit press CTRL+C\n";

$callback = function ($msg) {
    // TODO
    // Send the message to the Twilio API
    echo ' [x] ', $msg->body, "\n";
};

$channel->basic_consume('send_sms_queue', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
