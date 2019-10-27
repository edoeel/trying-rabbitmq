<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

// opening rabbitmq connection
$connection = new AMQPStreamConnection(
    \getenv('RABBITMQ_HOST'),
    \getenv('RABBITMQ_PORT'),
    \getenv('RABBITMQ_USER'),
    \getenv('RABBITMQ_PASSWORD')
);

// connecting to one of free channel
$channel = $connection->channel();
echo " [*] Connected to {$channel->getChannelId()} channel\n";

// creating an exchange if not exists
$exchangeName = 'logs';
$channel->exchange_declare($exchangeName, 'fanout', false, false, false);

// get queue temporary name
[$queueName, ,] = $channel->queue_declare('', false, false, true, false);

// bind queue to exchange
$channel->queue_bind($queueName, $exchangeName);

echo " [*] Waiting for logs. To exit press CTRL+C\n";
$callback = static function ($msg) {
    echo ' [x] ', $msg->body, "\n";
};

$channel->basic_consume($queueName, '', false, true, false, false, $callback);

// does not close connection while consuming
while ($channel->is_consuming()) {
    $channel->wait();
}

// closing connection
$channel->close();
$connection->close();
