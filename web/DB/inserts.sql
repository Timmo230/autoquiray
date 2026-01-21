INSERT INTO users (requistration_id, document_id, document_type, name, email, type, active, passwd, administrator_id) VALUES
('admin001','00000001X','DNI','Admin Uno','admin1@autoquiray.com','administrator',1,'rootpass111','admin000'),
('admin002','00000002X','DNI','Admin Dos','admin2@autoquiray.com','administrator',1,'rootpass222','admin000'),
('admin003','00000003X','DNI','Admin Tres','admin3@autoquiray.com','administrator',1,'rootpass333','admin000'),
('admin004','00000004X','DNI','Admin Cuatro','admin4@autoquiray.com','administrator',1,'rootpass444','admin000');

INSERT INTO administrators (requistration_id, salary) VALUES
('admin001',1000.00),
('admin002',1200.00),
('admin003',1100.00),
('admin004',1150.00);

-- 3️⃣ PROFESORES
INSERT INTO users (requistration_id, document_id, document_type, name, email, type, active, passwd, administrator_id) VALUES
('teacher001','11111111A','DNI','Profesor Uno','profesor1@autoquiray.com','teacher',1,'teachpass1','admin000'),
('teacher002','11111112A','DNI','Profesor Dos','profesor2@autoquiray.com','teacher',1,'teachpass2','admin000'),
('teacher003','11111113A','DNI','Profesor Tres','profesor3@autoquiray.com','teacher',1,'teachpass3','admin000'),
('teacher004','11111114A','DNI','Profesor Cuatro','profesor4@autoquiray.com','teacher',1,'teachpass4','admin000'),
('teacher005','11111115A','DNI','Profesor Cinco','profesor5@autoquiray.com','teacher',1,'teachpass5','admin000'),
('teacher006','11111116A','DNI','Profesor Seis','profesor6@autoquiray.com','teacher',1,'teachpass6','admin000'),
('teacher007','11111117A','DNI','Profesor Siete','profesor7@autoquiray.com','teacher',1,'teachpass7','admin000'),
('teacher008','11111118A','DNI','Profesor Ocho','profesor8@autoquiray.com','teacher',1,'teachpass8','admin000');

INSERT INTO teachers (requistration_id, salary) VALUES
('teacher001',1500.00),
('teacher002',1600.00),
('teacher003',1550.00),
('teacher004',1580.00),
('teacher005',1520.00),
('teacher006',1570.00),
('teacher007',1590.00),
('teacher008',1600.00);

-- 4️⃣ 50 ESTUDIANTES
INSERT INTO users (requistration_id, document_id, document_type, name, email, type, active, passwd, administrator_id) VALUES
('stu001','22222222B','DNI','Estudiante 1','student1@autoquiray.com','student',1,'studpass1','admin000'),
('stu002','22222223B','DNI','Estudiante 2','student2@autoquiray.com','student',1,'studpass2','admin000'),
('stu003','22222224B','DNI','Estudiante 3','student3@autoquiray.com','student',1,'studpass3','admin000'),
('stu004','22222225B','DNI','Estudiante 4','student4@autoquiray.com','student',1,'studpass4','admin000'),
('stu005','22222226B','DNI','Estudiante 5','student5@autoquiray.com','student',1,'studpass5','admin001'),
('stu006','22222227B','DNI','Estudiante 6','student6@autoquiray.com','student',1,'studpass6','admin001'),
('stu007','22222228B','DNI','Estudiante 7','student7@autoquiray.com','student',1,'studpass7','admin001'),
('stu008','22222229B','DNI','Estudiante 8','student8@autoquiray.com','student',1,'studpass8','admin001'),
('stu009','22222230B','DNI','Estudiante 9','student9@autoquiray.com','student',1,'studpass9','admin002'),
('stu010','22222231B','DNI','Estudiante 10','student10@autoquiray.com','student',1,'studpass10','admin002'),
('stu011','22222232B','DNI','Estudiante 11','student11@autoquiray.com','student',1,'studpass11','admin002'),
('stu012','22222233B','DNI','Estudiante 12','student12@autoquiray.com','student',1,'studpass12','admin002'),
('stu013','22222234B','DNI','Estudiante 13','student13@autoquiray.com','student',1,'studpass13','admin003'),
('stu014','22222235B','DNI','Estudiante 14','student14@autoquiray.com','student',1,'studpass14','admin003'),
('stu015','22222236B','DNI','Estudiante 15','student15@autoquiray.com','student',1,'studpass15','admin003'),
('stu016','22222237B','DNI','Estudiante 16','student16@autoquiray.com','student',1,'studpass16','admin003'),
('stu017','22222238B','DNI','Estudiante 17','student17@autoquiray.com','student',1,'studpass17','admin004'),
('stu018','22222239B','DNI','Estudiante 18','student18@autoquiray.com','student',1,'studpass18','admin004'),
('stu019','22222240B','DNI','Estudiante 19','student19@autoquiray.com','student',1,'studpass19','admin004'),
('stu020','22222241B','DNI','Estudiante 20','student20@autoquiray.com','student',1,'studpass20','admin004'),
('stu021','22222242B','DNI','Estudiante 21','student21@autoquiray.com','student',1,'studpass21','admin001'),
('stu022','22222243B','DNI','Estudiante 22','student22@autoquiray.com','student',1,'studpass22','admin001'),
('stu023','22222244B','DNI','Estudiante 23','student23@autoquiray.com','student',1,'studpass23','admin001'),
('stu024','22222245B','DNI','Estudiante 24','student24@autoquiray.com','student',1,'studpass24','admin001'),
('stu025','22222246B','DNI','Estudiante 25','student25@autoquiray.com','student',1,'studpass25','admin002'),
('stu026','22222247B','DNI','Estudiante 26','student26@autoquiray.com','student',1,'studpass26','admin002'),
('stu027','22222248B','DNI','Estudiante 27','student27@autoquiray.com','student',1,'studpass27','admin002'),
('stu028','22222249B','DNI','Estudiante 28','student28@autoquiray.com','student',1,'studpass28','admin002'),
('stu029','22222250B','DNI','Estudiante 29','student29@autoquiray.com','student',1,'studpass29','admin003'),
('stu030','22222251B','DNI','Estudiante 30','student30@autoquiray.com','student',1,'studpass30','admin003'),
('stu031','22222252B','DNI','Estudiante 31','student31@autoquiray.com','student',1,'studpass31','admin003'),
('stu032','22222253B','DNI','Estudiante 32','student32@autoquiray.com','student',1,'studpass32','admin003'),
('stu033','22222254B','DNI','Estudiante 33','student33@autoquiray.com','student',1,'studpass33','admin003'),
('stu034','22222255B','DNI','Estudiante 34','student34@autoquiray.com','student',1,'studpass34','admin003'),
('stu035','22222256B','DNI','Estudiante 35','student35@autoquiray.com','student',1,'studpass35','admin004'),
('stu036','22222257B','DNI','Estudiante 36','student36@autoquiray.com','student',1,'studpass36','admin004'),
('stu037','22222258B','DNI','Estudiante 37','student37@autoquiray.com','student',1,'studpass37','admin004'),
('stu038','22222259B','DNI','Estudiante 38','student38@autoquiray.com','student',1,'studpass38','admin004'),
('stu039','22222260B','DNI','Estudiante 39','student39@autoquiray.com','student',1,'studpass39','admin001'),
('stu040','22222261B','DNI','Estudiante 40','student40@autoquiray.com','student',1,'studpass40','admin001'),
('stu041','22222262B','DNI','Estudiante 41','student41@autoquiray.com','student',1,'studpass41','admin001'),
('stu042','22222263B','DNI','Estudiante 42','student42@autoquiray.com','student',1,'studpass42','admin001'),
('stu043','22222264B','DNI','Estudiante 43','student43@autoquiray.com','student',1,'studpass43','admin002'),
('stu044','22222265B','DNI','Estudiante 44','student44@autoquiray.com','student',1,'studpass44','admin002'),
('stu045','22222266B','DNI','Estudiante 45','student45@autoquiray.com','student',1,'studpass45','admin002'),
('stu046','22222267B','DNI','Estudiante 46','student46@autoquiray.com','student',1,'studpass46','admin002'),
('stu047','22222268B','DNI','Estudiante 47','student47@autoquiray.com','student',1,'studpass47','admin003'),
('stu048','22222269B','DNI','Estudiante 48','student48@autoquiray.com','student',1,'studpass48','admin003'),
('stu049','22222270B','DNI','Estudiante 49','student49@autoquiray.com','student',1,'studpass49','admin004'),
('stu050','22222271B','DNI','Estudiante 50','student50@autoquiray.com','student',1,'studpass50','admin004');

INSERT INTO students (requistration_id, permission) VALUES
('stu001','A1'),('stu002','A2'),('stu003','A1'),('stu004','A2'),
('stu005','A'),('stu006','B'),('stu007','A1'),('stu008','A2'),
('stu009','A'),('stu010','B'),('stu011','A1'),('stu012','A2'),
('stu013','A'),('stu014','B'),('stu015','A1'),('stu016','A2'),
('stu017','A'),('stu018','B'),('stu019','A1'),('stu020','A2'),
('stu021','A'),('stu022','B'),('stu023','A1'),('stu024','A2'),
('stu025','A'),('stu026','B'),('stu027','A1'),('stu028','A2'),
('stu029','A'),('stu030','B'),('stu031','A1'),('stu032','A2'),
('stu033','A'),('stu034','B'),('stu035','A1'),('stu036','A2'),
('stu037','A'),('stu038','B'),('stu039','A1'),('stu040','A2'),
('stu041','A'),('stu042','B'),('stu043','A1'),('stu044','A2'),
('stu045','A'),('stu046','B'),('stu047','A1'),('stu048','A2'),
('stu049','A'),('stu050','B');

INSERT INTO examns (id, date, start_time, type, permission, price) VALUES
(1,'2026-02-01','09:00:00','theorist','A1',100.00),
(2,'2026-02-02','10:00:00','practical','A2',120.00);

INSERT INTO registers (student_id, exam_id, note) VALUES
('stu001',1,NULL),
('stu002',2,NULL);

INSERT INTO timetables (id, administrator_id, date, start_time, end_time) VALUES
(1,'admin001','2026-02-05','08:00:00','10:00:00'),
(2,'admin002','2026-02-06','09:00:00','11:00:00');

INSERT INTO classes (id, teacher_id, timetable_id, title, max_students, maximun_students, permission) VALUES
(1,'teacher001',1,'Clase A1',30,1,'A1'),
(2,'teacher002',2,'Clase A2',25,1,'A2');

INSERT INTO students_reserves_classes (student_id, class_id) VALUES
('stu001',1),
('stu002',2);

INSERT INTO student_questions (id, student_id, menssage, date_sent, affair) VALUES
(1,'stu001','Pregunta sobre examen 1','2026-01-20 10:00:00','Examen'),
(2,'stu002','Pregunta sobre examen 2','2026-01-20 11:00:00','Examen');

INSERT INTO answers (id, question_id, teacher_id, menssage, date_sent) VALUES
(1,1,'teacher001','Respuesta de prueba 1','2026-01-20 11:00:00'),
(2,2,'teacher002','Respuesta de prueba 2','2026-01-20 12:00:00');

INSERT INTO tests (id, teacher_id, title, permission) VALUES
(1,'teacher001','Test A1','A1'),
(2,'teacher002','Test A2','A2');

INSERT INTO question_tests (id, teacher_id, title, option1, option2, option3, correct_option) VALUES
(1,'teacher001','Pregunta Test 1','Opción 1','Opción 2','Opción 3','a'),
(2,'teacher002','Pregunta Test 2','Opción A','Opción B','Opción C','b');

INSERT INTO tests_have_questions (test_id, question_id) VALUES
(1,1),
(2,2);

INSERT INTO students_do_tests (student_id, test_id, last_note) VALUES
('stu001',1,0),
('stu002',2,0);