INSERT INTO users (DNI, name, email, type) VALUES
('555E', 'Ana Torres', 'ana@correo.com', 'student'),
('666F', 'Luis Fernández', 'luis@correo.com', 'student'),
('777G', 'Marta Díaz', 'marta@correo.com', 'student'),
('888H', 'Pedro Sánchez', 'pedro@correo.com', 'student'),
('999I', 'Sofía Morales', 'sofia@correo.com', 'student'),
('101J', 'Raúl Jiménez', 'raul@correo.com', 'teacher'),
('102K', 'Elena Castro', 'elena@correo.com', 'teacher'),
('103L', 'Jorge Navarro', 'jorge@correo.com', 'administrator'),
('104M', 'Isabel Ortega', 'isabel@correo.com', 'administrator'),
('111A', 'Juan Pérez', 'juan@correo.com', 'student'),
('222B', 'María López', 'maria@correo.com', 'student'),
('333C', 'Carlos Ruiz', 'carlos@correo.com', 'teacher'),
('444D', 'Laura Gómez', 'laura@correo.com', 'administrator');

INSERT INTO students (DNI, active) VALUES
('111A', 1),
('222B', 1),
('555E', 1),
('666F', 1),
('777G', 1),
('888H', 1),
('999I', 1);

INSERT INTO teachers (DNI) VALUES
('333C'),
('101J'),
('102K');

INSERT INTO administrators (DNI) VALUES
('444D'),
('103L'),
('104M');

INSERT INTO student_questions (student_DNI, menssage, date_sent, affair) VALUES
('111A', 'No entiendo el tema 3', NOW(), 'Dudas examen'),
('222B', '¿Cuándo es el test?', NOW(), 'Fecha test');

INSERT INTO answers (question_relacionated_id, teacher_DNI, menssage, date_sent) VALUES
(1, '333C', 'Repasa los apuntes y pregúntame en clase', NOW()),
(2, '333C', 'El test es el viernes', NOW());

INSERT INTO tests (teacher_DNI, title) VALUES
('333C', 'Test HTML'),
('333C', 'Test CSS');

INSERT INTO question_tests (title, option1, option2, option3) VALUES
('¿Cuál es la velocidad máxima en ciudad?', '50 km/h', '80 km/h', '30 km/h'),
('¿Qué significa una luz amarilla intermitente?', 'Precaución', 'Stop obligatorio', 'Prohibido girar'),
('¿Cuál es la distancia mínima de seguridad?', '2 segundos', '5 metros', '10 metros'),
('¿Qué indica una señal de ceda el paso?', 'Prioridad al tráfico en la vía principal', 'Prohibido continuar', 'Solo peatones'),
('¿Qué documentación debes llevar siempre en el coche?', 'Permiso de conducir y seguro', 'Carta de identidad', 'Carné de estudiante'),
('¿Qué hacer ante un stop?', 'Parar completamente y ceder el paso', 'Reducir velocidad y continuar', 'Solo mirar a la izquierda'),
('¿Qué indica un semáforo en rojo?', 'Detenerse', 'Avanzar con cuidado', 'Prioridad al peatón'),
('¿Qué debes revisar antes de conducir?', 'Aceite, frenos y luces', 'Radio y GPS', 'Neumáticos únicamente'),
('¿Qué significa una línea continua en la carretera?', 'Prohibido adelantar', 'Se puede adelantar', 'Solo ciclistas'),
('¿Qué hacer si un vehículo de emergencia se acerca con sirena?', 'Apartarse y detenerse', 'Acelerar', 'Ignorar'),
('¿Qué significa la señal de prohibido girar a la derecha?', 'No girar a la derecha', 'Solo vehículos grandes', 'Girar con precaución'),
('¿Cuál es la prioridad en una rotonda?', 'Vehículos que ya están dentro', 'Vehículos que entran', 'Bicicletas siempre'),
('¿Qué hacer si llueve mientras conduces?', 'Reducir velocidad y aumentar distancia de seguridad', 'Acelerar para salir rápido', 'Encender luces largas y seguir igual'),
('¿Qué indica una línea discontinua en la carretera?', 'Se puede adelantar si hay visibilidad', 'No se puede adelantar', 'Solo ciclistas pueden cruzarla'),
('¿Qué significa un triángulo rojo con borde blanco?', 'Señal de peligro', 'Stop obligatorio', 'Ceda el paso'),
('¿Qué hacer ante un paso de peatones con personas cruzando?', 'Parar y ceder el paso', 'Reducir velocidad pero seguir', 'Solo parar si hay niños'),
('¿Qué equipo es obligatorio en el coche?', 'Cinturón de seguridad', 'Radio', 'Claxon extra'),
('¿Qué significa un semáforo ámbar fijo?', 'Detenerse si es seguro', 'Acelerar antes de que cambie a rojo', 'Prioridad a peatones'),
('¿Qué hacer si el ABS se activa?', 'Mantener presión en el freno y controlar el volante', 'Soltar el freno', 'Acelerar para recuperar control'),
('¿Cuál es la velocidad máxima en autopista?', '120 km/h', '80 km/h', '100 km/h'),
('¿Qué hacer si te aproximas a un paso a nivel sin barrera?', 'Disminuir velocidad y mirar ambas direcciones', 'Acelerar para cruzar rápido', 'Ignorar las señales'),
('¿Qué significa una señal azul con una P?', 'Zona de estacionamiento permitido', 'Prohibido aparcar', 'Parada obligatoria'),
('¿Qué hacer si se enciende la luz de aceite?', 'Parar el coche y revisar aceite', 'Seguir conduciendo hasta el taller', 'Ignorar si el motor suena bien'),
('¿Qué indica un bordillo pintado de amarillo?', 'Prohibido estacionar', 'Zona de carga y descarga', 'Solo taxis pueden aparcar'),
('¿Cuál es la edad mínima para conducir un coche?', '18 años', '16 años', '21 años'),
('¿Qué hacer al aproximarse a un cruce sin señalización?', 'Ceder el paso a quien venga por la derecha', 'Acelerar para pasar primero', 'Prioridad al que va más rápido'),
('¿Qué indica una señal triangular con un coche derrapando?', 'Calzada resbaladiza', 'Vehículos pesados', 'Zona de obras'),
('¿Qué distancia recorrerías en 2 segundos a 90 km/h?', '50 metros aproximadamente', '10 metros', '100 metros'),
('¿Qué significa una línea amarilla continua al lado del bordillo?', 'Prohibido estacionar', 'Solo carga y descarga', 'Zona de peatones'),
('¿Qué hacer al conducir de noche en carretera sin iluminación?', 'Encender luces largas y reducir velocidad', 'Encender luces cortas y acelerar', 'Apagar luces largas para no deslumbrar a otros'),
('¿Cuál es la presión mínima de neumáticos recomendada?', 'Según fabricante del vehículo', '1 bar siempre', '2 bar para todos los coches'),
('¿Qué significa un círculo rojo con una barra horizontal blanca?', 'Prohibido el paso', 'Stop obligatorio', 'Ceda el paso'),
('¿Qué hacer si te encuentras un semáforo en ámbar intermitente?', 'Reducir velocidad y cruzar con precaución', 'Detenerse siempre', 'Acelerar para pasar rápido'),
('¿Qué indica un triángulo con un peatón dentro?', 'Paso de peatones', 'Prohibido cruzar', 'Solo bicicletas'),
('¿Qué hacer si un vehículo delante hace un cambio brusco de carril?', 'Mantener distancia y anticiparse', 'Acelerar para adelantar', 'Ignorar la maniobra'),
('¿Qué indica un carril pintado con líneas en zig-zag?', 'Proximidad de paso de peatones', 'Zona de adelantamiento permitido', 'Solo para bicicletas'),
('¿Qué documento necesitas para inspección técnica del vehículo (ITV)?', 'Tarjeta de ITV vigente', 'Carné de conducir', 'Permiso de circulación'),
('¿Qué hacer ante un conductor agresivo?', 'Mantener distancia y no responder', 'Acercarse para discutir', 'Adelantar a toda velocidad'),
('¿Qué indica un círculo azul con flecha blanca hacia la derecha?', 'Obligación de girar a la derecha', 'Prohibido girar', 'Solo peatones'),
('¿Qué hacer si hay niebla densa?', 'Encender luces antiniebla y reducir velocidad', 'Seguir igual', 'Usar luces largas y acelerar'),
('¿Qué significa un semáforo en verde intermitente?', 'Cruce próximo y precaución', 'Detenerse', 'Prioridad absoluta');

INSERT INTO tests_have_questions (test_id, question_id) VALUES
(1, 1),
(1, 2),
(2, 2);

INSERT INTO students_do_tests (student_DNI, test_id, last_note) VALUES
('111A', 1, 8),
('222B', 1, 7),
('111A', 2, 9);

INSERT INTO timetables (administrator_DNI, date, start_time, end_time) VALUES
('444D', '2026-01-20 00:00:00', '10:00:00', '12:00:00');

INSERT INTO classes (teacher_DNI, timetable_id, title, max_students, full) VALUES
('333C', 1, 'Clase de HTML', 20, 0);

INSERT INTO students_reserves_classes (student_DNI, class_id) VALUES
('111A', 1),
('222B', 1);