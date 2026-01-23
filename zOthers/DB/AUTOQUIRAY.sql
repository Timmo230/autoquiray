DROP DATABASE IF EXISTS  autoquiray;

CREATE DATABASE autoquiray;

USE autoquiray;


CREATE TABLE permissions(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    permission VARCHAR(255) NOT NULL
);

CREATE TABLE users(
    id VARCHAR(255) PRIMARY KEY,
    document_id VARCHAR(255) NOT NULL,
    document_type ENUM("DNI", "passport") NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    type ENUM("student", "teacher", "administrator") NOT NULL,
    active BOOLEAN NOT NULL DEFAULT 1,
    passwd VARCHAR(255) NOT NULL
);

CREATE TABLE students(
    user_id VARCHAR(255) NOT NULL PRIMARY KEY,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE examns(
    id INT UNSIGNED PRIMARY KEY,
    permission_id INT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    type ENUM("theorist", "practical"),
    price DECIMAL(8, 2) NOT NULL,

    FOREIGN KEY (permission_id) REFERENCES permissions(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE registers(
    student_id VARCHAR(255) NOT NULL,
    exam_id INT UNSIGNED NOT NULL,
    note INT UNSIGNED NULL,

    FOREIGN KEY (student_id) REFERENCES students(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (exam_id) REFERENCES examns(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE employees(
    user_id VARCHAR(255) NOT NULL PRIMARY KEY,
    salary DECIMAL(8, 2) NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE teachers(
    employees_id VARCHAR(255) NOT NULL PRIMARY KEY,

    FOREIGN KEY (employees_id) REFERENCES employees(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE administrators(
    employees_id VARCHAR(255) NOT NULL PRIMARY KEY,

    FOREIGN KEY (employees_id) REFERENCES employees(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

ALTER TABLE users
ADD administrator_id VARCHAR(255) NULL,
ADD FOREIGN KEY (administrator_id) REFERENCES administrators(employees_id)
    ON UPDATE CASCADE
    ON DELETE SET NULL;

CREATE TABLE student_questions(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(255) DEFAULT NULL,
    menssage VARCHAR(512) NOT NULL,
    date_sent DATETIME NOT NULL,
    affair VARCHAR(255) NOT NULL,

    FOREIGN KEY (student_id) REFERENCES students(user_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE answers(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    question_id INT UNSIGNED NOT NULL,
    teacher_id VARCHAR(255) NULL DEFAULT NULL,
    menssage VARCHAR(512) NOT NULL,
    date_sent DATETIME NOT NULL,

    FOREIGN KEY (question_id) REFERENCES student_questions(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (teacher_id) REFERENCES teachers(employees_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE tests(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id VARCHAR(255) NULL DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    max_not INT UNSIGNED NOT NULL,

    FOREIGN KEY (teacher_id) REFERENCES teachers(employees_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE permissions_are_associated_test(
    test_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (test_id) REFERENCES tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    PRIMARY KEY (test_id, permission_id)
);

CREATE TABLE question_tests(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id VARCHAR(255) NULL DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    correct_option_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (teacher_id) REFERENCES teachers(employees_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE tests_have_questions(
    test_id INT UNSIGNED NOT NULL,
    question_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (test_id) REFERENCES tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (question_id) REFERENCES question_tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE options(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    question_id INT UNSIGNED NOT NULL,
    option VARCHAR(255) NOT NULL,

    FOREIGN KEY (question_id) REFERENCES question_tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE student_completes_tests(
    student_id VARCHAR(255) NOT NULL,
    test_id INT UNSIGNED NOT NULL,
    last_note INT UNSIGNED NOT NULL,

    FOREIGN KEY (student_id) REFERENCES students(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (test_id) REFERENCES tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE timetables(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    administrator_id VARCHAR(255) NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,

    FOREIGN KEY (administrator_id) REFERENCES administrators(employees_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE classes(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id VARCHAR(255) NOT NULL,
    timetable_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    max_students INT UNSIGNED NOT NULL,

    FOREIGN KEY (teacher_id) REFERENCES teachers(employees_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (timetable_id) REFERENCES timetables(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE permissions_are_tought_in_classes(
    class_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (class_id) REFERENCES classes(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (permission_id) REFERENCES permissions(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    PRIMARY KEY (class_id, permission_id)
);

CREATE TABLE students_reserves_classes(
    student_id VARCHAR(255) NOT NULL,
    class_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (student_id) REFERENCES students(user_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    
    FOREIGN KEY (class_id) REFERENCES classes(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE tutions(
    id VARCHAR(255) PRIMARY KEY,
    administrator_id VARCHAR(255) NULL,
    student_id VARCHAR(255) NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    start_date DATE NOT NULL,
    max_end_date DATE NOT NULL,
    status ENUM("pendientePago", "matriculado", "expirado", "finalizado") NOT NULL,
    price DECIMAL(8, 2) NOT NULL,

    FOREIGN KEY (administrator_id) REFERENCES administrators(employees_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    
    FOREIGN KEY (student_id) REFERENCES students(user_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);