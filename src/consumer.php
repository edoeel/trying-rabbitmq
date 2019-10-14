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

// creating a queue if not exists
$queueName = 'hello';
$channel->queue_declare($queueName, false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

// consuming message
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

// does not close connection while consuming
while ($channel->is_consuming()) {
    $channel->wait();
}

// closing connection
$channel->close();
$connection->close();