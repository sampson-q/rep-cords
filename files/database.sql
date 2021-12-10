CREATE DATABASE IF NOT EXISTS repnotes DEFAULT CHARACTER SET utf8;

USE repnotes;

CREATE TABLE IF NOT EXISTS person(
    id VARCHAR(10) PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    middlename VARCHAR(30),
    lastname VARCHAR(30) NOT NULL,
    class VARCHAR(6) NOT NULL,
    program_type VARCHAR(20) NOT NULL,
    user_level INT(3) NOT NULL,
    student_email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(1000) NOT NULL,
    CONSTRAINT uid FOREIGN KEY(student_id) REFERENCES person(id) ON UPDATE CASCADE
);

CREATE TABLE `repnotes`.`all_class` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `student_id` VARCHAR(10) NOT NULL,
    `class_names` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS securityQuestions(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL UNIQUE,
    security_question VARCHAR(200) NOT NULL,
    security_answer VARCHAR(200) NOT NULL,
    CONSTRAINT uid FOREIGN KEY(student_id) REFERENCES users(student_id)
);

CREATE TABLE IF NOT EXISTS qualiusers(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(10) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS payment_analysis (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    analysis VARCHAR(60) NOT NULL
);

CREATE TABLE IF NOT EXISTS payment (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    amount_received DOUBLE DEFAULT 0,
    recorded_date VARCHAR(30) NOT NULL,
    recorded_datetime VARCHAR(30) NOT NULL,
    recorded_year VARCHAR(10) NOT NULL,
    recorded_month VARCHAR(15) NOT NULL,
    folio VARCHAR(10) NOT NULL,
    item_description VARCHAR(100) NOT NULL,
    voucher_number VARCHAR(10) NOT NULL,
    total_amount DOUBLE NOT NULL,
    payment_analysis_id INTEGER NOT NULL,
    CONSTRAINT us FOREIGN KEY(student_id) REFERENCES person(id) ON UPDATE CASCADE,
    CONSTRAINT pay FOREIGN KEY(payment_analysis_id) REFERENCES payment_analysis(id) ON UPDATE CASCADE
);

INSERT INTO payment_analysis (analysis) VALUES ("Stationary");
INSERT INTO payment_analysis (analysis) VALUES ("Fare");
INSERT INTO payment_analysis (analysis) VALUES ("Postage");
INSERT INTO payment_analysis (analysis) VALUES ("Miscellaneous");