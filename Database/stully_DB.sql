-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2021-04-08 10:52:04.152

-- tables
-- Table: Account
CREATE TABLE Account (
    Account_ID int NOT NULL,
    Username varchar(15) NOT NULL,
    Password_hash varchar(255) NOT NULL,
    Email varchar(50) NOT NULL,
    Punten int NOT NULL,
    CONSTRAINT Account_pk PRIMARY KEY (Account_ID)
);

-- Table: Comments
CREATE TABLE Comments (
    Comment_id int NOT NULL,
    Comment text NOT NULL,
    punten int NOT NULL,
    Post_ID int NOT NULL,
    Account_ID int NOT NULL,
    CONSTRAINT Comments_pk PRIMARY KEY (Comment_id)
);

-- Table: Posts
CREATE TABLE Posts (
    Post_ID int NOT NULL,
    Code text NOT NULL,
    Account_ID int NOT NULL,
    CONSTRAINT Posts_pk PRIMARY KEY (Post_ID)
);

-- foreign keys
-- Reference: comments_Account (table: Comments)
ALTER TABLE Comments ADD CONSTRAINT comments_Account FOREIGN KEY comments_Account (Account_ID)
    REFERENCES Account (Account_ID);

-- Reference: comments_posts (table: Comments)
ALTER TABLE Comments ADD CONSTRAINT comments_posts FOREIGN KEY comments_posts (Post_ID)
    REFERENCES Posts (Post_ID);

-- Reference: posts_Account (table: Posts)
ALTER TABLE Posts ADD CONSTRAINT posts_Account FOREIGN KEY posts_Account (Account_ID)
    REFERENCES Account (Account_ID);

-- End of file.

