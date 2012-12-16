DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
    Username VARCHAR(16) primary key,
    Pass VARCHAR(16),
    FName VARCHAR(16),
    LName VARCHAR(16)
);

INSERT INTO Users VALUES ('Guest','Guest','Guest','Guest'); -- Used to initialize. Not accessible to anyone

DROP TABLE IF EXISTS Cabinet;
CREATE TABLE Cabinet
(
    Username VARCHAR(16),
    Ingredient VARCHAR(100)
);

DROP TABLE IF EXISTS Recipes;
CREATE TABLE Recipes
(
    RecipeName VARCHAR(100) primary key,
    Servings VARCHAR(64)
);

DROP TABLE IF EXISTS Ingredients;
CREATE TABLE Ingredients
(
    RecipeName VARCHAR(100),
    Ingredient VARCHAR(100), -- DM Edit
    Quantity VARCHAR(100) -- DM Edit - Reason for VARCHAR is it may be teaspoon/tablespoon etc
);

DROP TABLE IF EXISTS Instructions;
CREATE TABLE Instructions
(
    RecipeName VARCHAR(100) primary key,
    Instructions TEXT
);

DROP TABLE IF EXISTS Images;
CREATE TABLE Images
(
    RecipeName VARCHAR(100) primary key,
    ImageUrl VARCHAR(300)
);
