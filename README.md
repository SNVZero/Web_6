SQL TABLE CREATED

CREATE TABLE users (
     id int(10) unsigned NOT NULL AUTO_INCREMENT,
     login varchar(128) NOT NULL DEFAULT 'login',
     pass varchar(128) NOT NULL DEFAULT 'pass',
     name varchar(128) NOT NULL DEFAULT 'name',
     mail varchar(128) NOT NULL DEFAULT 'email',
     bio varchar(256) NOT NULL DEFAULT 'bio',
     date varchar(10) NOT NULL DEFAULT '01-01-1970',
     gender varchar(1) NOT NULL DEFAULT '-',
     limbs varchar(2) NOT NULL DEFAULT '4',
     PRIMARY KEY (id)
     );

 CREATE TABLE super_power (
     id int(10) unsigned NOT NULL AUTO_INCREMENT,
     human_id int(10) unsigned NOT NULL,
     superabilities VARCHAR(128) NOT NULL,
     PRIMARY KEY (id)
     );

 CREATE TABLE admin (
    -> id int(10) unsigned NOT NULL AUTO_INCREMENT,
    -> login varchar(128) NOT NULL DEFAULT 'login',
    -> password varchar(128) NOT NULL DEFAULT 'pass',
    -> PRIMARY KEY (id)
    -> );
