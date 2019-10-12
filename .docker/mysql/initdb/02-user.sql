CREATE USER 'rabbitmq-user'@'%' IDENTIFIED BY 'rabbitmq-password';
GRANT ALL ON `rabbitmq-db`.* TO 'rabbitmq-user'@'%';
FLUSH PRIVILEGES;