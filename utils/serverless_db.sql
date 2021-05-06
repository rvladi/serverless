DROP DATABASE IF EXISTS serverless;
CREATE DATABASE serverless;
USE serverless;

CREATE TABLE users
(
    id       INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (username)
);

CREATE TABLE funcs
(
    id          INT NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    description VARCHAR(4094) NOT NULL,
    body        TEXT NOT NULL,
    created     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated     DATETIME NULL,
    executed    DATETIME NULL,
    executions  INT NOT NULL DEFAULT 0,
    creator     INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (creator) REFERENCES users(id)
);
