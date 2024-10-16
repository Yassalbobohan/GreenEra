CREATE DATABASE report;

USE report;

CREATE TABLE report (
    rep_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cats VARCHAR(50) NOT NULL,
    description VARCHAR(300) NOT NULL,
    fileName VARCHAR(500) NOT NULL,
    rep_date DATETIME NOT NULL,
);