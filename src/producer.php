<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// opening rabbitmq connection
$connection = new AMQPStreamConnection(
    \getenv('RABBITMQ_HOST'),
    \getenv('RABBITMQ_PORT'),
    \getenv('RABBITMQ_USER'),
    \getenv('RABBITMQ_PASSWORD')
);

// connection to one of free channel
$channel = $connection->channel();

// creating queue if not exist
$queueName = 'queue01';
$channel->queue_declare($queueName, false, false, false, false);

// publishing message
$textMsg = 'Hello World from ' . date('Y-m-d H:i:s');
$msg = new AMQPMessage($textMsg);
$channel->basic_publish($msg, '', $queueName);
echo " [x] Sent '{$textMsg}'\n";

$channel->close();
$connection->close();