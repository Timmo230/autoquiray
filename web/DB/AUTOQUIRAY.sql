DROP DATABASE IF EXISTS  autoquiray;

CREATE DATABASE autoquiray;

USE autoquiray;


CREATE TABLE users(
    requistration_id VARCHAR(255) PRIMARY KEY,
    document_id VARCHAR(255) NOT NULL,
    document_type ENUM("DNI", "passport") NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    type ENUM("student", "teacher", "administrator") NOT NULL,
    active BOOLEAN NOT NULL DEFAULT 1,
    passwd VARCHAR(255) NOT NULL
);

CREATE TABLE students(
    requistration_id VARCHAR(255) NOT NULL PRIMARY KEY,
    permission ENUM("A1", "A2", "A", "B") NOT NULL,

    FOREIGN KEY (requistration_id) REFERENCES users(requistration_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE examns(
    id INT UNSIGNED PRIMARY KEY,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    type ENUM("theorist", "practical"),
    permission ENUM("A1", "A2", "A", "B") NOT NULL,
    price DECIMAL(8, 2) NOT NULL
);

CREATE TABLE registers(
    student_id VARCHAR(255) NOT NULL,
    exam_id INT UNSIGNED NOT NULL,
    note INT UNSIGNED NULL,

    FOREIGN KEY (student_id) REFERENCES students(requistration_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (exam_id) REFERENCES examns(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE teachers(
    requistration_id VARCHAR(255) NOT NULL PRIMARY KEY,
    salary DECIMAL(8, 2) NOT NULL,

    FOREIGN KEY (requistration_id) REFERENCES users(requistration_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE administrators(
    requistration_id VARCHAR(255) NOT NULL PRIMARY KEY,
    salary DECIMAL(8, 2) NOT NULL,

    FOREIGN KEY (requistration_id) REFERENCES users(requistration_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

ALTER TABLE users
ADD administrator_id VARCHAR(255) NULL,
ADD FOREIGN KEY (administrator_id) REFERENCES users(requistration_id)
    ON UPDATE CASCADE
    ON DELETE SET NULL;

CREATE TABLE student_questions(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(255) DEFAULT NULL,
    menssage VARCHAR(512) NOT NULL,
    date_sent DATETIME NOT NULL,
    affair VARCHAR(255) NOT NULL,

    FOREIGN KEY (student_id) REFERENCES students(requistration_id)
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
    
    FOREIGN KEY (teacher_id) REFERENCES teachers(requistration_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE tests(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id VARCHAR(255) NULL DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    permission ENUM("A1", "A2", "A", "B") NOT NULL,

    FOREIGN KEY (teacher_id) REFERENCES teachers(requistration_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE question_tests(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id VARCHAR(255) NULL DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    option1 VARCHAR(512) NOT NULL,
    option2 VARCHAR(512) NOT NULL,
    option3 VARCHAR(512) NOT NULL,
    correct_option ENUM("a", "b", "c") NOT NULL,

    FOREIGN KEY (teacher_id) REFERENCES teachers(requistration_id)
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

CREATE TABLE students_do_tests(
    student_id VARCHAR(255) NOT NULL,
    test_id INT UNSIGNED NOT NULL,
    last_note INT UNSIGNED NOT NULL,

    FOREIGN KEY (student_id) REFERENCES students(requistration_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (test_id) REFERENCES tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE timetables(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    administrator_id VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,

    FOREIGN KEY (administrator_id) REFERENCES administrators(requistration_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE classes(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id VARCHAR(255) NOT NULL,
    timetable_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    max_students INT UNSIGNED NOT NULL,
    maximun_students BOOLEAN NOT NULL,
    permission ENUM("A1", "A2", "A", "B") NOT NULL,

    FOREIGN KEY (teacher_id) REFERENCES teachers(requistration_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (timetable_id) REFERENCES timetables(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE students_reserves_classes(
    student_id VARCHAR(255) NOT NULL,
    class_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (student_id) REFERENCES students(requistration_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    
    FOREIGN KEY (class_id) REFERENCES classes(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);