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

// connection to one of free channel
$channel = $connection->channel();
echo 'Channel id: ' . $channel->getChannelId() . "\n";

// creating queue if not exist
$queueName = 'queue01';
$channel->queue_declare($queueName, false, false, false, false);

$callback = static function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};
$channel->basic_consume($queueName, '', false, true, false, false, $callback);
if ($channel->is_consuming()) {
    $channel->wait();
}
