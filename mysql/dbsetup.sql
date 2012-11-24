-- Acess mysql through MAMP for local use
-- Download http://www.mamp.info/en/downloads/index.html
-- /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot

-- Create a newuser for this project
CREATE USER 'cs41512_recman'@'localhost' IDENTIFIED BY 'pass';

-- Create dbfinal;
CREATE database cs41512_recipe_db;

-- Grant user access
GRANT ALL ON cs41512_recipe_db.* TO 'cs41512_recman'@'localhost';

-- Load up tables in db using recipes.sql
-- \. /home/user/..../recipes.sql
-- \. /home/user/.../procedures.sql


