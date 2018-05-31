
/* create user table */

create table users(
    id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    uid varchar(256) not null,
    firstname varchar(256) not null,
    lastname varchar(256) not null,
    email varchar(256) not null,
    pwd varchar(256) not null
);