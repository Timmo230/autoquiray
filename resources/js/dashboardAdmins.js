const list = document.getElementById('teacherStatsList');
const modal = new bootstrap.Modal(document.getElementById('teacherStatsModal'));
const modalTeacherName = document.getElementById('modalTeacherName');

const detailsContent = document.getElementById('detailsModalContent');
const modalDetails = new bootstrap.Modal(document.getElementById('detailsModal'));

const answers = 0;
const tests = 1;
const classes = 2;

const loadingDots = `<div class="loading-box" id="loadingState">
                        <div class="loading-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="loading-text">Cargando datos</div>
                    </div>`;

async function showTeacherStats(teacherID, action){
    modal.show();
    list.innerHTML = loadingDots;

    const post = await fetch('/autoquiray/admin/dashboard/stats', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                solicited: action,
                teacherID: teacherID,
            })
        });

    let result = await post.json();
    if(!result.ok){
        modal.hide();
        alert(result.message);
        return;
    } 

    if(result.data.length == 0 || result.data == null) {
        list.innerHTML = `<div class="empty-modal-state">
                            No hay datos para mostrar.
                        </div>`;
        return;
    }
    
    list.innerHTML = '';
    modalTeacherName.textContent = result.teacherName;
    if(action == answers) setAnswers(result);
    else if(action == tests) setTests(result);
    else if(action == classes) setClasses(result);
}

async function openDetail(elementID, action) {
    modalDetails.show();
    detailsContent.innerHTML = loadingDots;

    const post = await fetch('/autoquiray/admin/dashboard/details', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                solicited: action,
                elementID: elementID,
            })
        });

    let result = await post.json();
    if(!result.ok){
        modalDetails.hide();
        alert(result.message);
        return;
    }

    detailsContent.innerHTML = '';
    if(action == answers) setAnswersDetails(result);
    else if(action == tests) setTestsDetails(result);
    else if(action == classes) setClassesDetails(result);
    else alert("fallo");
}

function setAnswers(result){
    result.data.forEach(item => {
        list.insertAdjacentHTML('beforeend',`
                    <div class="stats-item">
                        <div class="stats-item-left">
                            <div class="stats-item-title">${item['affair']}</div>
                            <div class="stats-item-meta">Mensaje de: ${item['name']}</div>
                            <div class="stats-item-preview">
                                ${item['answer']}
                            </div>
                        </div>

                        <div class="stats-item-right">
                            <div class="stats-item-date">${item['date']}</div>

                            <button class="stats-open-btn" onclick="openDetail('${item['id']}', 0)">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                Ver detalle
                            </button>
                        </div>
                    </div>`)
    });
}

function setTests(result){
    result.data.forEach(item => {
        list.insertAdjacentHTML('beforeend',`
                    <div class="stats-item">
                        <div class="stats-item-left">
                            <div class="stats-item-title">${item['title']}</div>

                            <div class="stats-item-meta">
                                Tipo: ${item['type']} · Tiempo máximo: ${item['max_time']} min · Nota máxima: ${item['max_note']}
                            </div>

                            <div class="stats-item-preview">
                                Permisos:
                                <div class="stats-permissions">
                                    ${item['permissions'].map(p => `<span class="stats-permission-badge">${p}</span>`).join('')}
                                </div>
                            </div>
                        </div>

                        <div class="stats-item-right">
                            <div class="stats-item-date">${item['date']}</div>

                            <button class="stats-open-btn" onclick="openDetail('${item['id']}', 1)">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                Ver detalle
                            </button>
                        </div>
                    </div>`)
    });
}

function setClasses(result){
    result.data.forEach(item => {
        list.insertAdjacentHTML('beforeend',`
                    <div class="stats-item">
                        <div class="stats-item-left">
                            <div class="stats-item-title">${item['title']}</div>

                            <div class="stats-item-meta">
                                ${item['date']} · ${item['start_time']} - ${item['end_time']}
                            </div>

                            <div class="stats-item-preview">
                                <div class="stats-item-preview">
                                    Permisos:
                                    <div class="stats-permissions">
                                        ${item['permissions'].map(p => `<span class="stats-permission-badge">${p}</span>`).join('')}
                                    </div>
                                </div>
                                <div class="stats-class-info">
                                    <span class="stats-class-pill">
                                        <i class="fa-solid fa-users"></i>
                                        Máx. alumnos: ${item['max_students']}
                                    </span>

                                    ${
                                        item['done']
                                            ? `<span class="stats-class-status stats-class-status-done">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Realizada
                                            </span>`
                                            : `<span class="stats-class-status stats-class-status-future">
                                                    <i class="fa-solid fa-clock"></i>
                                                    Pendiente
                                            </span>`
                                    }
                                </div>
                            </div>
                        </div>

                        <div class="stats-item-right">
                            <div class="stats-item-date">Clase</div>

                            <button class="stats-open-btn" onclick="openDetail('${item['id']}', 2)">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                Ver detalle
                            </button>
                        </div>
                    </div>`)
    });
}

function setAnswersDetails(result){
    item = result.data;

    let dateTime = item.date_answer;
    let dateObj = new Date(dateTime.replace(' ', 'T'));
    let dateAnswer = dateObj.toLocaleDateString();
    let timeAnswer = dateObj.toLocaleTimeString();

    dateTime = item.date_question;
    dateObj = new Date(dateTime.replace(' ', 'T'));
    let dateQuestion = dateObj.toLocaleDateString();
    let timeQuestion = dateObj.toLocaleTimeString();

    
    let teacherInitials = getInitials(item.teacher_name);
    let studentInitials = getInitials(item.student_name);
    
    detailsContent.insertAdjacentHTML('beforeend',`
                <div class="details-card">

                    <div class="details-card-header">
                        <span class="details-badge">Consulta</span>

                        <h5 class="details-subject">Asunto: ${item.affair}</h5>
                    </div>

                    <div class="details-chat-wrapper">

                        <div class="details-message-row details-message-row-left">
                            <div class="details-message-block">

                                <div class="details-user-header">
                                    <div class="details-avatar details-avatar-student">${studentInitials}</div>

                                    <div>
                                        <div class="details-user-name">${item.student_name}</div>

                                        <div class="details-user-date">Enviado el ${dateQuestion} a las ${timeQuestion}</div>
                                    </div>
                                </div>

                                <div class="details-bubble details-bubble-student">
                                    <div class="details-bubble-label">Mensaje del alumno</div>

                                    <p class="mb-0">
                                        ${item.question}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="details-message-row details-message-row-right">
                            <div class="details-message-block">

                                <div class="details-user-header details-user-header-right">
                                    <div class="details-user-info-right">
                                        <div class="details-user-name">${item.teacher_name}</div>

                                        <div class="details-user-date">Respondido el ${dateAnswer} a las ${timeAnswer}</div>
                                    </div>

                                    <div class="details-avatar details-avatar-teacher">${teacherInitials}</div>
                                </div>

                                <div class="details-bubble details-bubble-teacher">
                                    <div class="details-bubble-label">Respuesta del profesor</div>

                                    <!-- MODIFICABLE: respuesta profesor -->
                                    <p class="mb-0">
                                        ${item.answer}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>`);
}

function setTestsDetails(result){
    item = result.data;

    teacherInitial = getInitials(item.teacherName);
    detailsContent.innerHTML = `
                <div class="details-card">

                    <div class="details-card-header">
                        <span class="details-badge">Test</span>
                        <h5 class="details-subject">Título: ${item.testTitle}</h5>
                    </div>

                    <div class="details-chat-wrapper">

                        <!-- DATOS GENERALES -->
                        <div class="details-message-row details-message-row-left">
                            <div class="details-message-block w-100">

                                <div class="details-user-header">
                                    <div class="details-avatar details-avatar-teacher">${teacherInitial}</div>

                                    <div>
                                        <div class="details-user-name">${item.teacherName}</div>
                                        <div class="details-user-date">Información general del test</div>
                                    </div>
                                </div>

                                <div class="details-bubble details-bubble-teacher">
                                    <div class="details-bubble-label">Datos principales</div>

                                    <div class="row g-3">
                                        <div class="col-md-6"><strong>Tipo:</strong> ${item.testType}</div>
                                        <div class="col-md-6"><strong>Nota máxima:</strong> ${item.max_note}</div>
                                        <div class="col-md-6"><strong>Tiempo máximo:</strong> ${item.max_time} min</div>
                                        <div class="col-md-6"><strong>Hecho por</strong> ${item.studentsCount} estudiantes</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PERMISOS -->
                        <div class="details-message-row details-message-row-left">
                            <div class="details-message-block w-100">

                                <div class="details-bubble details-bubble-student">
                                    <div class="details-bubble-label">Permisos</div>

                                    <div class="d-flex flex-wrap gap-2">
                                        ${item.permissions.map(p=> `<span class="details-badge">${p}</span>`).join('')}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PREGUNTAS + TOTAL ALUMNOS -->
                        <div class="details-message-row details-message-row-left">
                            <div class="details-message-block w-100">

                                <div class="details-bubble details-bubble-student" id="questionContainer">

                                    <div class="details-bubble-label">Preguntas</div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>`;
    
    setQuestionsDetails(item);
}

function setQuestionsDetails(item){
    const questionContainer = document.getElementById("questionContainer");
    let counter = 0;
    item.questions.forEach(e => {
        questionContainer.insertAdjacentHTML('beforeend',`
            <div class="border rounded-4 p-3 mb-3" id="question${counter}">
            </div>`);
        
        const actualQuestion = document.getElementById(`question${counter}`);
        
        actualQuestion.innerHTML = `
            <div class="fw-semibold mb-3">
                ${counter + 1}. ${e.questionTitle}
            </div>`;
        
        e.options.forEach(o=> {
            if(o.is_correct){
                actualQuestion.insertAdjacentHTML('beforeend', `
                    <div class="details-option-correct px-3 py-2 rounded-3 border">
                        ${o.option}
                    </div>
                `);
            }else{
                actualQuestion.insertAdjacentHTML('beforeend', `
                    <div class="details-option-normal px-3 py-2 rounded-3 border">
                        ${o.option}
                    </div>
                `);
            }
        })
        
        counter++;
    });
}

function setClassesDetails(result){
    let item = result.data;

    teacherInitial = getInitials(item.teacherName);
    detailsContent.innerHTML = `
    <div class="details-card class-details-card">

        <div class="details-card-header">
            <span class="details-badge">Clase</span>
            <h5 class="details-subject">Título: ${item.title}</h5>
        </div>

        <div class="details-chat-wrapper">

            <!-- DATOS GENERALES -->
            <div class="details-message-row details-message-row-left">
                <div class="details-message-block w-100">

                    <div class="details-user-header">
                        <div class="details-avatar details-avatar-teacher">${teacherInitial}</div>

                        <div>
                            <div class="details-user-name">J${item.teacherName}</div>
                            <div class="details-user-date">Información general de la clase</div>
                        </div>
                    </div>

                    <div class="details-bubble details-bubble-teacher">
                        <div class="details-bubble-label">Datos principales</div>

                        <div class="class-details-grid">
                            <div class="class-detail-item">
                                <span class="class-detail-label">Máximo de estudiantes</span>
                                <span class="class-detail-value">${item.max_students}</span>
                            </div>

                            <div class="class-detail-item">
                                <span class="class-detail-label">Fecha</span>
                                <span class="class-detail-value">${item.date}</span>
                            </div>

                            <div class="class-detail-item">
                                <span class="class-detail-label">Hora de entrada</span>
                                <span class="class-detail-value">${item.start_time}</span>
                            </div>

                            <div class="class-detail-item">
                                <span class="class-detail-label">Hora de salida</span>
                                <span class="class-detail-value">${item.end_time}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ESTADO -->
            <div class="details-message-row details-message-row-left">
                <div class="details-message-block w-100">
                    <div class="details-bubble details-bubble-student">
                        <div class="details-bubble-label">Estado de la clase</div>
                            ${result = item.done ? `
                                    <span class="class-status-badge class-status-pending">
                                        Pendiente
                                    </span> 
                                `:`
                                    <div class="class-status-row">
                                        <span class="class-status-badge class-status-done">Realizada</span>
                                    </div>
                                `}
                    </div>
                </div>
            </div>

            <!-- PERMISOS -->
            <div class="details-message-row details-message-row-left">
                <div class="details-message-block w-100">
                    <div class="details-bubble details-bubble-student">
                        <div class="details-bubble-label">Permisos relacionados</div>

                        <div class="d-flex flex-wrap gap-2">
                            ${item.permissions.map(p=> `<span class="details-badge">${p}</span>`).join('')}
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALUMNOS -->
            <div class="details-message-row details-message-row-right">
                <div class="details-message-block w-100">
                    <div class="details-bubble details-bubble-teacher">
                        ${result = item.done ? 
                            `<div class="details-bubble-label">Alumnos que han reservado</div>`:
                            `<div class="details-bubble-label">Alumnos que han participado</div>`
                        }
                        

                        <div class="class-students-summary">
                            <strong>Total:</strong> ${item.students.length} alumnos
                        </div>

                        <div class="class-students-list" id="students_list">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>`;

    setStudentsDetails(item.students, item.done);
}

function setStudentsDetails(students, done){
    studentStatus = done ? 
        `<div class="details-user-date">Alumno con reserva</div>`:
        `<div class="details-user-date">Alumno participante</div>`;

    const studentContainer = document.getElementById('students_list'); 
    students.forEach(student => {
        let initialStudent = getInitials(student);
        studentContainer.insertAdjacentHTML('beforeend',`
            <div class="class-student-card">
                <div class="class-student-left">
                    <div class="details-avatar details-avatar-student">${initialStudent}</div>
                    <div>
                        <div class="details-user-name">${student}</div>
                        <div class="details-user-date">${studentStatus}</div>
                    </div>
                </div>
            </div>
            `)
    });
}



function getInitials(name){
    return name
        .split(' ')
        .map(n => n.trim()[0])
        .filter(Boolean)
        .slice(0, 2)
        .join('')
        .toUpperCase();
}