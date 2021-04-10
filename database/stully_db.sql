-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2021-04-10 12:29:45.522

-- tables
-- Table: account
CREATE TABLE account (
    account_id int NOT NULL AUTO_INCREMENT,
    username varchar(15) NOT NULL,
    password_hash varchar(255) NOT NULL,
    email varchar(50) NOT NULL,
    punten int NOT NULL,
    status varchar(20) NOT NULL,
    CONSTRAINT account_pk PRIMARY KEY (account_id)
);

-- Table: comments
CREATE TABLE comments (
    comment_id int NOT NULL AUTO_INCREMENT,
    comment text NOT NULL,
    punten int NOT NULL,
    post_id int NOT NULL,
    account_id int NOT NULL,
    CONSTRAINT comments_pk PRIMARY KEY (comment_id)
);

-- Table: posts
CREATE TABLE posts (
    post_id int NOT NULL AUTO_INCREMENT,
    code text NOT NULL,
    account_id int NOT NULL,
    CONSTRAINT posts_pk PRIMARY KEY (post_id)
);

-- foreign keys
-- Reference: comments_Account (table: comments)
ALTER TABLE comments ADD CONSTRAINT comments_Account FOREIGN KEY comments_Account (account_id)
    REFERENCES account (account_id);

-- Reference: comments_posts (table: comments)
ALTER TABLE comments ADD CONSTRAINT comments_posts FOREIGN KEY comments_posts (post_id)
    REFERENCES posts (post_id);

-- Reference: posts_Account (table: posts)
ALTER TABLE posts ADD CONSTRAINT posts_Account FOREIGN KEY posts_Account (account_id)
    REFERENCES account (account_id);

-- End of file.

