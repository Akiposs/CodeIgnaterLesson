CREATE DATABASE codeignater_db;
CREATE USER 'codeignater_user'@'%' IDENTIFIED BY 'tmp1234';
GRANT ALL PRIVILEGES ON codeignater_db.* TO 'codeignater_user'@'%';