
/* users database */
create table IF NOT EXISTS users(
    id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    uid varchar(256) not null,
    firstname varchar(256) not null,
    lastname varchar(256) not null,
    email varchar(256) not null,
    pwd varchar(256) not null
);

/* message database */
create table IF NOT EXISTS messages(
    id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    content text not null,
    uid varchar(256) not null,
    time timestamp not null DEFAULT CURRENT_TIMESTAMP
);