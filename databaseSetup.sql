
--Run Once
-- @block
CREATE DATABASE ContactManager;

-- @block
-- also run once

-- Password size will depend on the hash algorithm.
CREATE TABLE Users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    passWord VARCHAR(255) NOT NULL,
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL
);

-- Size of each variable is up to discussion, or until new information is presented.
-- All contacts will be stored in this table, the parent_id will tell which contacts a user has.
CREATE TABLE Contacts (
    contact_id INT AUTO_INCREMENT,
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    preferFirst BOOLEAN,        -- Prefers first name if true, else prefer last.
    email VARCHAR(50) NOT NULL, -- cannot be unique to allow multiple users to have the same contacts.
    phone  INT UNSIGNED NOT NULL,
    creation DATE NOT NULL,      -- use DATETIME if the time is needed as well. Easier to search without the time.
    parent_id INT NOT NULL,
    PRIMARY KEY(contact_id),
    FOREIGN KEY(parent_id) REFERENCES Users(id)        -- allows this table to reference a user. via the user's id.
);


-- @block 
-- This is the format for adding a new user to the table
INSERT INTO Users(username, passWord, firstName, lastName)
VALUES
    ("davidP", "1234", "David", "Patenaude"),
    ("Lamp", "itsBright", "Office", "LAMP"),
    ("Shade", "tooDark", "Office", "SHADE");

-- @block
INSERT INTO contacts(firstName, lastName, preferFirst, email, phone, creation, parent_id)
VALUES
    ("David", "Patenaude", TRUE, "dpatenaude@knights.ucf.edu", 1234567890, CURDATE(), 1),
    ("John", "Doe", FALSE, "jd@ucf.edu", 1023456789, CURDATE(), 1);


-- SELECT id FROM users WHERE username="davidP"); -- would be used to get the ID to put into the command above.

-- @block
-- Examples of ways to seach the table

-- Example of using join to see all contacts that a particular user has.
SELECT username, parent_id, contact_id, firstName, lastName, email FROM contacts      -- (firstName, lastName, email)
INNER JOIN users
ON users.id = contacts.parent_id;


-- @block
-- indexing for faster accesses when searching for a pattern.
CREATE INDEX email_index ON Contacts(email);
