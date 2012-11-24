DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
    Username VARCHAR(16) primary key,
    Pass VARCHAR(16),
    FName VARCHAR(16),
    LName VARCHAR(16)
);

INSERT INTO Users VALUES ('ddeutsch', ' ', 'Dan', 'Deutsch');

DROP TABLE IF EXISTS CurrentUser;
CREATE TABLE CurrentUser
(
    Username VARCHAR(16) primary key
);

DROP TABLE IF EXISTS Cabinet;
CREATE TABLE Cabinet
(
    Username VARCHAR(16),
    Ingredient VARCHAR(32)
);

INSERT INTO Cabinet VALUES ('ddeutsch', 'eggs');
INSERT INTO Cabinet VALUES ('ddeutsch', 'milk');
INSERT INTO Cabinet VALUES ('ddeutsch', 'flour');
