DROP DATABASE IF EXISTS  autoquiray;

CREATE DATABASE autoquiray;

USE autoquiray;


CREATE TABLE users(
    DNI VARCHAR(255) PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    type ENUM("student", "teacher", "administrator") NOT NULL
);

CREATE TABLE students(
    DNI VARCHAR(255) NOT NULL PRIMARY KEY,
    active BOOLEAN NOT NULL DEFAULT 1,

    FOREIGN KEY (DNI) REFERENCES users(DNI)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE teachers(
    DNI VARCHAR(255) NOT NULL PRIMARY KEY,

    FOREIGN KEY (DNI) REFERENCES users(DNI)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE administrators(
    DNI VARCHAR(255) NOT NULL PRIMARY KEY,

    FOREIGN KEY (DNI) REFERENCES users(DNI)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE student_questions(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_DNI VARCHAR(255) NOT NULL,
    menssage VARCHAR(512) NOT NULL,
    date_sent DATETIME NOT NULL,
    affair VARCHAR(255) NOT NULL,

    FOREIGN KEY (student_DNI) REFERENCES students(DNI)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE answers(
    question_relacionated_id INT UNSIGNED PRIMARY KEY,
    teacher_DNI VARCHAR(255) NOT NULL,
    menssage VARCHAR(512) NOT NULL,
    date_sent DATETIME NOT NULL,

    FOREIGN KEY (question_relacionated_id) REFERENCES student_questions(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    
    FOREIGN KEY (teacher_DNI) REFERENCES teachers(DNI)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE tests(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_DNI VARCHAR(255) NULL,
    title VARCHAR(255) NOT NULL,

    FOREIGN KEY (teacher_DNI) REFERENCES teachers(DNI)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE question_tests(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    option1 VARCHAR(512) NOT NULL,
    option2 VARCHAR(512) NOT NULL,
    option3 VARCHAR(512) NOT NULL
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
    student_DNI VARCHAR(255) NOT NULL,
    test_id INT UNSIGNED NOT NULL,
    last_note INT UNSIGNED NOT NULL,

    FOREIGN KEY (student_DNI) REFERENCES students(DNI)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (test_id) REFERENCES tests(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE timetables(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    administrator_DNI VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,

    FOREIGN KEY (administrator_DNI) REFERENCES administrators(DNI)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE classes(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_DNI VARCHAR(255) NOT NULL,
    timetable_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    max_students INT UNSIGNED NOT NULL,
    full BOOLEAN NOT NULL,

    FOREIGN KEY (teacher_DNI) REFERENCES teachers(DNI)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    FOREIGN KEY (timetable_id) REFERENCES timetables(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE students_reserves_classes(
    student_DNI VARCHAR(255) NOT NULL,
    class_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (student_DNI) REFERENCES students(DNI)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    
    FOREIGN KEY (class_id) REFERENCES classes(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);