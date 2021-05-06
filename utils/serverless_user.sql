CREATE USER 'serverless'@'127.0.0.1' IDENTIFIED WITH mysql_native_password BY 'serverless';
GRANT ALL PRIVILEGES ON serverless.* TO 'serverless'@'127.0.0.1';
