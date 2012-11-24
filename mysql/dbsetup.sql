-- Acess mysql through MAMP for local use
-- Download http://www.mamp.info/en/downloads/index.html
-- /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot

-- Create a newuser for this project
CREATE USER 'jhudb'@'localhost' IDENTIFIED BY 'pass';

-- Create dbfinal;
CREATE database dbfinal;

-- Grant user access
GRANT ALL ON dbfinal.* TO 'jhudb'@'localhost';

-- Load up tables in db using recipes.sql
-- \. /home/user/..../recipes.sql
-- \. /home/user/.../procedures.sql


