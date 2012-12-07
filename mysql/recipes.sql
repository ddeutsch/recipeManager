DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
    Username VARCHAR(16) primary key,
    Pass VARCHAR(16),
    FName VARCHAR(16),
    LName VARCHAR(16)
);

INSERT INTO Users VALUES ('ddeutsch', ' ', 'Dan', 'Deutsch');

#We don't use this table anymore
#DROP TABLE IF EXISTS CurrentUser;

DROP TABLE IF EXISTS Cabinet;
CREATE TABLE Cabinet
(
    Username VARCHAR(16),
    Ingredient VARCHAR(100)
);

INSERT INTO Cabinet VALUES ('ddeutsch', 'eggs');
INSERT INTO Cabinet VALUES ('ddeutsch', 'milk');
INSERT INTO Cabinet VALUES ('ddeutsch', 'flour');

DROP TABLE IF EXISTS Recipes;
CREATE TABLE Recipes
(
    RecipeName VARCHAR(100) primary key,
    Servings VARCHAR(64)
);

INSERT INTO Recipes VALUES ('Chocolate Cheesecake', '6-8');
INSERT INTO Recipes VALUES ('Normal Cake', '5-10');
INSERT INTO Recipes VALUES ('Chicken Parmesan', '3-4');

DROP TABLE IF EXISTS Ingredients;
CREATE TABLE Ingredients
(
    RecipeName VARCHAR(100),
    Ingredient VARCHAR(100), -- DM Edit
    Quantity VARCHAR(100) -- DM Edit - Reason for VARCHAR is it may be teaspoon/tablespoon etc
);

INSERT INTO Ingredients VALUES ('Chocolate Cheesecake', 'milk','2');
INSERT INTO Ingredients VALUES ('Chocolate Cheesecake', 'eggs','2');
INSERT INTO Ingredients VALUES ('Chocolate Cheesecake', 'flour','2 cups');

INSERT INTO Ingredients VALUES ('Normal Cake', 'milk','10 ounces');

INSERT INTO Ingredients VALUES ('Chicken Parmesan', 'chicken', '1 whole breast');
INSERT INTO Ingredients VALUES ('Chicken Parmesan', 'cheese', '1 lb');
INSERT INTO Ingredients VALUES ('Chicken Parmesan', 'bread crumbs','2 tbsp');
INSERT INTO Ingredients VALUES ('Chicken Parmesan', 'pasta','1 full box');
INSERT INTO Ingredients VALUES ('Chicken Parmesan', 'pasta sauce','16 ounces');

DROP TABLE IF EXISTS Instructions;
CREATE TABLE Instructions
(
    RecipeName VARCHAR(100) primary key,
    Instructions TEXT
);

INSERT INTO Instructions VALUES ('Chocolate Cheesecake', 'Instructions go here');
INSERT INTO Instructions VALUES ('Normal Cake', 'Normal cake instructions go here');
INSERT INTO Instructions VALUES ('Chicken Parmesan', 'Preheat an oven to 450 degrees F (230 degrees C).\n
Place chicken breasts between two sheets of heavy plastic (resealable freezer bags work well) on a solid, level surface. Firmly pound chicken with the smooth side of a meat mallet to a thickness of 1/2-inch. Season chicken thoroughly with salt and pepper.\n
Beat eggs in a shallow bowl and set aside.\n
Mix bread crumbs and 1/2 cup Parmesan in a separate bowl, set aside.\n
Place flour in a sifter or strainer; sprinkle over chicken breasts, evenly coating both sides.\n
Dip flour coated chicken breast in beaten eggs. Transfer breast to breadcrumb mixture, pressing the crumbs into both sides. Repeat for each breast. Set aside breaded chicken breasts for about 15 minutes.\n
Heat 1 cup olive oil in a large skillet on medium-high heat until it begins to shimmer. Cook chicken until golden, about 2 minutes on each side. The chicken will finish cooking in the oven.\n
Place chicken in a baking dish and top each breast with about 1/3 cup of tomato sauce. Layer each chicken breast with equal amounts of mozzarella cheese, fresh basil, and provolone cheese. Sprinkle 1 to 2 tablespoons of Parmesan cheese on top and drizzle with 1 tablespoon olive oil.\n
Bake in the preheated oven until cheese is browned and bubbly, and chicken breasts are no longer pink in the center, 15 to 20 minutes. An instant-read thermometer inserted into the center should read at least 165 degrees F (74 degrees C).');


DROP TABLE IF EXISTS Images;
CREATE TABLE Images
(
    RecipeName VARCHAR(100) primary key,
    ImageUrl VARCHAR(300)
);
