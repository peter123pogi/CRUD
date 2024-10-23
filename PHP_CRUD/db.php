<?php
$con = new mysqli('localhost', 'root', '', 'delosreyes_crud');

/*
CREATE TABLE users (
    id INT PRIMARY KEY AUTO INCREMENT,
    name VARCHAR(22),
    age INT,
    sex ENUM('Male', 'Female'),
    email VARCHAR(299) NOT NULL DEFAULT 'No Info',
    contact_number VARCHAR(299) NOT NULL DEFAULT 'No Info',
    created_at TIMESTAMPS NOT NULL DEFAULT CURRENT_TIMESTAMP
);
*/