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

# Change the current user
DROP PROCEDURE IF EXISTS ChangeCurrentUser//
CREATE PROCEDURE ChangeCurrentUser(IN username VARCHAR(16))
BEGIN
    DROP TABLE IF EXISTS CurrentUser;
    CREATE TABLE CurrentUser(Username VARCHAR(16));
    INSERT INTO CurrentUser VALUES (username); 
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

DELIMITER ;


