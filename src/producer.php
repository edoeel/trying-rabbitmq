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

// connecting to one of free channel
$channel = $connection->channel();
echo " [*] Connected to {$channel->getChannelId()} channel\n";

// creating a queue if not exists
$queueName = 'hello';
$channel->queue_declare($queueName, false, false, false, false);

// creating message
$msgString = implode(' ', array_slice($argv, 1));
if (empty($msgString)) {
    $msgString = 'Hello World!';
}
$msg = new AMQPMessage($msgString);

// publishing message
$channel->basic_publish($msg, '', $queueName);
echo " [x] Sent '{$msgString}'\n";

// closing connection
$channel->close();
$connection->close();
