
--
-- Execute as MYSQL root
--

CREATE USER 'android'@'localhost' IDENTIFIED BY 'password';
CREATE DATABASE android;
GRANT ALL PRIVILEGES ON android . * TO 'android'@'localhost';

