# RabbitMQ Tutorial
Trying RabbitMQ with the [RabbitMQ get started](https://www.rabbitmq.com/getstarted.html) page

There are three branches:
- tutorial-one-hello-world: https://www.rabbitmq.com/tutorials/tutorial-one-php.html
- tutorial-two-work-queues: https://www.rabbitmq.com/tutorials/tutorial-two-php.html
- tutorial-three-publish: https://www.rabbitmq.com/tutorials/tutorial-three-php.html

<hr>

### How to
start docker containers
```sh
$ docker-compose up -d
```

go to RabbitMQ management page
```
http://localhost:15672/
```

produce a message
```sh
$ docker-compose exec php-fpm sh
$ php src/producer.php [MESSAGE]
```

start a consumer
```sh
$ docker-compose exec php-fpm sh
$ php src/consumer.php
```
