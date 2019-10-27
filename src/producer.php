<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @return string
 */
function generateMessage($argv): string
{
    $msgString = implode(' ', array_slice($argv, 1));
    if (true === empty($msgString)) {
        $msgString = 'Hello World!';
    }
    return $msgString;
}

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

// creating message
$msgString = generateMessage($_SERVER['argv']);
$msg = new AMQPMessage($msgString);

// publishing message to exchange
$channel->basic_publish($msg, $exchangeName);
echo " [x] Sent '{$msgString}'\n";

// closing connection
$channel->close();
$connection->close();
