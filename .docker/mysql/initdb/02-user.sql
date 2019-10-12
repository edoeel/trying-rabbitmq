CREATE USER 'rabbit-user'@'%' IDENTIFIED BY 'rabbit-password';
GRANT ALL ON `rabbit-db`.* TO 'rabbit-user'@'%';
FLUSH PRIVILEGES;