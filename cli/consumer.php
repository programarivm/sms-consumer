<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Twilio\Rest\Client as TwilioClient;

$dotenv = new Dotenv(__DIR__.'/../');
$dotenv->load();

$twilio = new TwilioClient(getenv('TWILIO_SID'), getenv('TWILIO_TOKEN'));

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
$callback = function ($msg) use ($twilio) {
    $message = unserialize($msg->body);
    $message = $twilio->messages->create(
        $message['tel'],
        [
            'from' => getenv('TWILIO_NUMBER'),
            'to' => $message['tel'],
            'body' => $message['content']
        ]
    );
    echo '[x] Message id: '.$message->sid.PHP_EOL;
    // TODO:
    // update the sms message status in the database
};

$channel->basic_consume('send_sms_queue', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
