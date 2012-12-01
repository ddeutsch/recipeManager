DELIMITER //

# Add user if doesnt already exist
DROP PROCEDURE IF EXISTS CreateUser//
CREATE PROCEDURE CreateUser(IN username VARCHAR(16), IN pass VARCHAR(16), IN fname VARCHAR(16), IN lname VARCHAR(16))
BEGIN
	IF NOT EXISTS (SELECT * FROM Users U WHERE U.Username = username) THEN
		INSERT INTO Users VALUES (username, pass, fname, lname);
		
		SELECT * FROM Users;
	ELSE
		SELECT 'User already exists!' AS 'Error Message';
	END IF;
END;
//

# Validate if the username and password are correct
DROP PROCEDURE IF EXISTS ValidateUser//
CREATE PROCEDURE ValidateUser(IN username VARCHAR(16), IN password VARCHAR(16))
BEGIN
    IF NOT EXISTS (SELECT * FROM Users U WHERE U.Username = username AND U.Pass = password) THEN
	SELECT 'Incorrect Username or Password' AS 'Error Message';
    ELSE
	SELECT * FROM Users U WHERE U.Username = username;
    END IF;
END;
//

# Check to see what recipes a user can make
DROP PROCEDURE IF EXISTS FindCabinetRecipes//
CREATE PROCEDURE FindCabinetRecipes(IN username VARCHAR(16))
BEGIN
    SELECT T3.RecipeName
    FROM
    (
        SELECT I.RecipeName, COUNT(*) NumIngredients
        FROM Ingredients I
        GROUP BY I.RecipeName
    ) T3
    JOIN
    (
        SELECT I.RecipeName, COUNT(*) Common
        FROM Ingredients I JOIN
    (
        SELECT C.Ingredient
        FROM Cabinet C
        WHERE C.Username = "ddeutsch"
    ) T1
        ON T1.Ingredient = I.Ingredient
        GROUP BY I.RecipeName
    ) T4
    ON T3.RecipeName = T4.RecipeName
    WHERE T3.NumIngredients = T4.Common;
END;
//


DELIMITER ;


