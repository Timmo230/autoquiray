<?php

namespace Database\Seeders\Support;

class RealisticSeedCatalog
{
    public static function namedUsers(): array
    {
        return [
            [
                'name' => 'Alejandro López Muñoz',
                'email' => 'alejandro.lopez.munoz@autoquiray.test',
                'document_id' => '48273195T',
                'roles' => ['administrator'],
            ],
            [
                'name' => 'Sidelly González Ciruela',
                'email' => 'sidelly.gonzalez.ciruela@autoquiray.test',
                'document_id' => '59318462M',
                'roles' => ['administrator'],
            ],
            [
                'name' => 'Matías Álvaro Quiriquino El Ashuh',
                'email' => 'matias.alvaro.quiriquino@autoquiray.test',
                'document_id' => '71620548R',
                'roles' => ['administrator'],
            ],
            [
                'name' => 'Jorge Muñoz Martínez',
                'email' => 'jorge.munoz.martinez@autoquiray.test',
                'document_id' => '62481953L',
                'roles' => ['teacher'],
            ],
            [
                'name' => 'Hugo Muñoz Martínez',
                'email' => 'hugo.munoz.martinez@autoquiray.test',
                'document_id' => '35817426P',
                'roles' => ['teacher'],
            ],
            [
                'name' => 'Juan Ignacio López Pichardo',
                'email' => 'juanignacio.lopez.pichardo@autoquiray.test',
                'document_id' => '44192837C',
                'roles' => ['teacher'],
            ],
            [
                'name' => 'Iker Macías Almida',
                'email' => 'iker.macias.almida@autoquiray.test',
                'document_id' => '53164728H',
                'roles' => ['teacher'],
            ],
            [
                'name' => 'Aday Vicente Benítez',
                'email' => 'aday.vicente.benitez@autoquiray.test',
                'document_id' => '28374615S',
                'roles' => ['student'],
            ],
            [
                'name' => 'Yldefonso García García',
                'email' => 'yldefonso.garcia.garcia@autoquiray.test',
                'document_id' => '67418235N',
                'roles' => ['student'],
            ],
            [
                'name' => 'José Luis González Luna',
                'email' => 'joseluis.gonzalez.luna@autoquiray.test',
                'document_id' => '39821547B',
                'roles' => ['student'],
            ],
            [
                'name' => 'Pedro Alejandro Joya Máñez',
                'email' => 'pedroalejandro.joya.manez@autoquiray.test',
                'document_id' => '45736821Q',
                'roles' => ['student'],
            ],
        ];
    }

    public static function permissions(): array
    {
        return ['AM', 'A1', 'A2', 'B', 'C1', 'C', 'D1', 'D', 'BE', 'CE'];
    }

    public static function classTitles(): array
    {
        return [
            'Normativa básica y prioridades de paso',
            'Señalización vertical y marcas viales',
            'Conducción preventiva en ciudad',
            'Velocidad, distancia de seguridad y frenado',
            'Uso eficiente del vehículo y consumo responsable',
            'Maniobras de estacionamiento y giros',
            'Incorporaciones, adelantamientos y cambios de carril',
            'Conducción nocturna y con climatología adversa',
            'Primeros auxilios y actuación en accidente',
            'Mecánica básica para conductores',
            'Preparación de examen teórico B',
            'Preparación de examen práctico B',
        ];
    }

    public static function testDefinitions(): array
    {
        return [
            [
                'type' => 'senales',
                'title' => 'Test intensivo de señales verticales',
                'permission' => 'B',
                'question_count' => 10,
            ],
            [
                'type' => 'senales',
                'title' => 'Reconocimiento de señales de obligación y peligro',
                'permission' => 'B',
                'question_count' => 10,
            ],
            [
                'type' => 'circulacion',
                'title' => 'Normas de circulación urbana',
                'permission' => 'B',
                'question_count' => 10,
            ],
            [
                'type' => 'circulacion',
                'title' => 'Prioridades, intersecciones y glorietas',
                'permission' => 'B',
                'question_count' => 10,
            ],
            [
                'type' => 'seguridad',
                'title' => 'Conducción segura y prevención de riesgos',
                'permission' => 'B',
                'question_count' => 10,
            ],
            [
                'type' => 'seguridad',
                'title' => 'Seguridad vial y factores de riesgo',
                'permission' => 'B',
                'question_count' => 10,
            ],
            [
                'type' => 'dgt',
                'title' => 'Simulacro oficial DGT 1',
                'permission' => 'B',
                'question_count' => 30,
            ],
            [
                'type' => 'dgt',
                'title' => 'Simulacro oficial DGT 2',
                'permission' => 'B',
                'question_count' => 30,
            ],
        ];
    }

    public static function questionBank(): array
    {
        return [
            'senales' => [
                [
                    'title' => '¿Qué indica una señal triangular con borde rojo?',
                    'options' => [
                        'Una advertencia de peligro',
                        'Una obligación para todos los conductores',
                        'Una indicación de servicio',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => '¿Qué significa una señal circular azul?',
                    'options' => [
                        'Una recomendación sin carácter obligatorio',
                        'Una obligación o vía reservada',
                        'Una prohibición temporal',
                    ],
                    'correct' => 1,
                ],
                [
                    'title' => 'La señal de stop obliga a:',
                    'options' => [
                        'Reducir la velocidad y continuar si no viene nadie',
                        'Detenerse por completo antes de reanudar la marcha',
                        'Ceder el paso solo a peatones',
                    ],
                    'correct' => 1,
                ],
                [
                    'title' => 'Una línea amarilla continua en el bordillo suele indicar:',
                    'options' => [
                        'Prohibición de parar y estacionar',
                        'Zona de carga y descarga sin restricciones',
                        'Aparcamiento exclusivo para residentes',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'La señal de entrada prohibida identifica:',
                    'options' => [
                        'Un carril reservado para autobuses',
                        'Una vía por la que no se puede acceder',
                        'Una calzada con prioridad',
                    ],
                    'correct' => 1,
                ],
            ],
            'circulacion' => [
                [
                    'title' => 'En una glorieta, ¿quién tiene prioridad con carácter general?',
                    'options' => [
                        'El vehículo que pretende entrar',
                        'El vehículo que circula dentro de la glorieta',
                        'El vehículo más grande',
                    ],
                    'correct' => 1,
                ],
                [
                    'title' => 'Antes de cambiar de carril, el conductor debe:',
                    'options' => [
                        'Señalizar, observar y efectuar la maniobra cuando sea segura',
                        'Acelerar sin señalizar para terminar antes',
                        'Usar solo el espejo interior',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'En un paso de peatones sin semáforo, la prioridad corresponde a:',
                    'options' => [
                        'Los peatones que vayan a cruzar',
                        'Los vehículos que ya circulan por la vía',
                        'El vehículo que llegue primero',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'Adelantar está prohibido cuando:',
                    'options' => [
                        'La visibilidad es insuficiente y existe línea continua',
                        'La vía tiene dos carriles por sentido',
                        'El vehículo adelantado circula despacio',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'En una incorporación a autopista, el conductor debe:',
                    'options' => [
                        'Detenerse siempre al final del carril de aceleración',
                        'Ajustar su velocidad y ceder el paso a los que ya circulan',
                        'Entrar directamente para no perder velocidad',
                    ],
                    'correct' => 1,
                ],
            ],
            'seguridad' => [
                [
                    'title' => '¿Cuál es la principal función del cinturón de seguridad?',
                    'options' => [
                        'Evitar desplazamientos peligrosos del ocupante en un impacto',
                        'Reducir el consumo de combustible',
                        'Mejorar la visibilidad del conductor',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'La distancia de seguridad debe aumentar especialmente cuando:',
                    'options' => [
                        'La calzada está mojada o hay poca visibilidad',
                        'Se circula por una vía urbana',
                        'El vehículo tiene neumáticos nuevos',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'Con fatiga al volante, lo más seguro es:',
                    'options' => [
                        'Abrir la ventanilla y continuar',
                        'Parar a descansar antes de seguir',
                        'Subir el volumen de la radio',
                    ],
                    'correct' => 1,
                ],
                [
                    'title' => 'Los neumáticos en mal estado aumentan:',
                    'options' => [
                        'La adherencia en curvas',
                        'El riesgo de accidente y la distancia de frenado',
                        'La estabilidad del vehículo',
                    ],
                    'correct' => 1,
                ],
                [
                    'title' => 'Después de consumir alcohol, la conducción:',
                    'options' => [
                        'Puede verse afectada aunque la persona se encuentre bien',
                        'Solo se altera si se conduce de noche',
                        'No cambia si el trayecto es corto',
                    ],
                    'correct' => 0,
                ],
            ],
            'dgt' => [
                [
                    'title' => '¿Qué debe hacer si un agente regula el tráfico con el brazo levantado?',
                    'options' => [
                        'Detenerse salvo que ya no pueda hacerlo con seguridad',
                        'Continuar con precaución',
                        'Acelerar para despejar la intersección',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'En vías interurbanas, usar el móvil al volante supone:',
                    'options' => [
                        'Una distracción grave y sancionable',
                        'Una conducta permitida si se circula despacio',
                        'Un riesgo solo para conductores noveles',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => '¿Cuándo debe usar el alumbrado de corto alcance?',
                    'options' => [
                        'Entre la puesta y la salida del sol o con baja visibilidad',
                        'Solo en túneles',
                        'Únicamente en travesías',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'Si un vehículo de emergencia se aproxima en servicio urgente, debe:',
                    'options' => [
                        'Facilitarle el paso apartándose con seguridad',
                        'Mantener la trayectoria y velocidad',
                        'Detenerse en mitad del carril',
                    ],
                    'correct' => 0,
                ],
                [
                    'title' => 'En caso de aquaplaning, lo más recomendable es:',
                    'options' => [
                        'Sujetar el volante con firmeza y levantar suavemente el pie del acelerador',
                        'Frenar bruscamente',
                        'Girar el volante de un lado a otro',
                    ],
                    'correct' => 0,
                ],
            ],
        ];
    }

    public static function studentQuestionSubjects(): array
    {
        return [
            'Duda sobre una maniobra de estacionamiento',
            'Consulta sobre fechas de examen',
            'Revisión de fallo en test teórico',
            'Información sobre clases prácticas',
            'Solicitud de cambio de horario',
        ];
    }

    public static function studentQuestionMessages(): array
    {
        return [
            'No tengo claro cuándo debo ceder el paso al salir de una plaza en batería. ¿Podéis explicármelo en clase?',
            'Quería saber si ya hay fecha prevista para el próximo examen teórico del permiso B.',
            'He fallado varias preguntas sobre prioridad en glorietas y me gustaría repasar ese tema.',
            '¿Es posible reservar una práctica extra de aparcamiento para la próxima semana?',
            'Trabajo por las tardes y quería consultar si hay hueco en grupos de mañana.',
        ];
    }

    public static function teacherAnswerMessages(): array
    {
        return [
            'Lo revisamos en la próxima clase y te enseñamos una referencia sencilla para hacerlo bien siempre.',
            'La convocatoria provisional está prevista para la segunda quincena del mes. Te avisaremos en cuanto se confirme.',
            'Te recomiendo repetir el bloque de circulación urbana y hacer un simulacro completo antes del viernes.',
            'Sí, podemos añadir una práctica extra. Habla con administración para cerrar la hora.',
            'Tenemos disponibilidad por la mañana dos días a la semana. Te lo dejamos anotado.',
        ];
    }
}
