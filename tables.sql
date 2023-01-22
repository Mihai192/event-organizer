CREATE DATABASE `event-organizer`;

CREATE TABLE `User` (
    id             INT NOT NULL AUTO_INCREMENT,
    nume           VARCHAR(30) NOT NULL,
    prenume        VARCHAR(30) NOT NULL,
    email          VARCHAR(255) NOT NULL,
    password       VARCHAR(64) NOT NULL,
    adresa         VARCHAR(64),
    salt           VARCHAR(64) NOT NULL,
    user_type      INT NOT NULL,
    session_token  VARCHAR(120), /* hash(hash(email + password) + salt)) */
    status         INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);

CREATE TABLE Token (
    id    INT NOT NULL AUTO_INCREMENT,
    hash  VARCHAR(120) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES User(id),
    PRIMARY KEY(id)
);


CREATE TABLE `Event` (
    id INT NOT NULL AUTO_INCREMENT,
    nume  VARCHAR(50) NOT NULL,
    data  TIMESTAMP NOT NULL,
    tipEveniment INT NOT NULL,
    adresa VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
); 



CREATE TABLE `EventUser` (
    id          INT NOT NULL AUTO_INCREMENT,
    user_id     INT NOT NULL,
    event_id    INT NOT NULL,
    role_type   INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES User(id),
    FOREIGN KEY(event_id) REFERENCES Event(id),
    PRIMARY KEY(id)
);

CREATE TABLE EventActivity (
    id          INT NOT NULL AUTO_INCREMENT,
    titlu       VARCHAR(80) NOT NULL,
    detalii     VARCHAR(255),
    deadline    TIMESTAMP NOT NULL,
    event_id    INT NOT NULL,
    status      INT NOT NULL,
    FOREIGN KEY(event_id) REFERENCES Event(id),
    PRIMARY KEY(id)
);

CREATE TABLE EventActivityKeyword (
    id          INT NOT NULL AUTO_INCREMENT,
    event_activity_id INT NOT NULL,
    keyword   VARCHAR(50) NOT NULL,
    FOREIGN KEY(event_activity_id) REFERENCES EventActivity(id),
    PRIMARY KEY(id)
);

CREATE TABLE BudgetList(
    id    INT NOT NULL AUTO_INCREMENT,
    nume VARCHAR(128) NOT NULL,
    PRIMARY KEY(id)
);


CREATE TABLE BudgetListItem(
    id   INT NOT NULL AUTO_INCREMENT,
    nume VARCHAR(80) NOT NULL,
    nr_unitati INT,
    pret_unitate INT,
    avans INT,
    rest_de_plata INT,
    budget_list_id INT NOT NULL,
    event_id INT NOT NULL,
    FOREIGN KEY(budget_list_id) REFERENCES BudgetList(id),
    FOREIGN KEY(event_id) REFERENCES Event(id),
    PRIMARY KEY(id)
);

CREATE TABLE `Group`(
    id   INT NOT NULL AUTO_INCREMENT,
    nume VARCHAR(60) NOT NULL,
    num_of_guests INT NOT NULL,
    table_id INT,
    group_type INT,
    confirm_status INT,
    event_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    FOREIGN KEY(event_id) REFERENCES Event(id),
    PRIMARY KEY(id)
);

CREATE TABLE Group_type(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Menu(
    id INT NOT NULL AUTO_INCREMENT,
    menu_type INT NOT NULL,
    group_id INT NOT NULL,
    num INT NOT NULL,
    FOREIGN KEY(group_id) REFERENCES `Group`(id),
    PRIMARY KEY(id)
);

CREATE TABLE Menu_Type(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    PRIMARY KEY(id)
);




CREATE TABLE `Table`(
    id INT NOT NULL AUTO_INCREMENT,
    nume VARCHAR(64) NOT NULL,
    num_of_sits INT NOT NULL,
    event_id INT NOT NULL,
    FOREIGN KEY(event_id) REFERENCES Event(id),
    PRIMARY KEY(id)
);


CREATE TABLE TableGroup(
    id INT NOT NULL AUTO_INCREMENT,
    table_id INT NOT NULL,
    group_id INT NOT NULL,
    FOREIGN KEY(table_id) REFERENCES `Table`(id),
    FOREIGN KEY(group_id) REFERENCES `Group`(id),
    PRIMARY KEY(id)
);

