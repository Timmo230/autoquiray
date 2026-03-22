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
    if(action == answers){
        setAnswersDetails(result);
        return;
    }
    alert("fallo");
}

`<div class="details-card">

    <div class="details-card-header">
        <span class="details-badge">Test</span>
        <h5 class="details-subject">Título: Test de circulación básica</h5>
    </div>

    <div class="details-chat-wrapper">

        <!-- DATOS GENERALES -->
        <div class="details-message-row details-message-row-left">
            <div class="details-message-block w-100">

                <div class="details-user-header">
                    <div class="details-avatar details-avatar-teacher">JP</div>

                    <div>
                        <div class="details-user-name">Juan Pérez</div>
                        <div class="details-user-date">Información general del test</div>
                    </div>
                </div>

                <div class="details-bubble details-bubble-teacher">
                    <div class="details-bubble-label">Datos principales</div>

                    <div class="row g-3">
                        <div class="col-md-6"><strong>Tipo:</strong> Tipo test</div>
                        <div class="col-md-6"><strong>Nota máxima:</strong> 10</div>
                        <div class="col-md-6"><strong>Tiempo máximo:</strong> 30 min</div>
                        <div class="col-md-6"><strong>Preguntas:</strong> 3</div>
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
                        <span class="details-badge">B</span>
                        <span class="details-badge">A2</span>
                        <span class="details-badge">AM</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PREGUNTAS + TOTAL ALUMNOS -->
        <div class="details-message-row details-message-row-left">
            <div class="details-message-block w-100">

                <div class="details-bubble details-bubble-student">
                    
                    <!-- TOTAL ARRIBA -->
                    <div class="mb-3">
                        <strong>Alumnos que lo han realizado:</strong> 2
                    </div>

                    <div class="details-bubble-label">Preguntas</div>

                    <!-- PREGUNTA 1 -->
                    <div class="border rounded-4 p-3 mb-3">
                        <div class="fw-semibold mb-3">
                            1. ¿Qué indica esta señal?
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <div class="details-option-normal px-3 py-2 rounded-3 border">
                                Ceda el paso
                            </div>

                            <div class="details-option-correct px-3 py-2 rounded-3 border">
                                Stop (Correcta)
                            </div>

                            <div class="details-option-normal px-3 py-2 rounded-3 border">
                                Prohibido el paso
                            </div>
                        </div>
                    </div>

                    <!-- PREGUNTA 2 -->
                    <div class="border rounded-4 p-3 mb-3">
                        <div class="fw-semibold mb-3">
                            2. ¿Cuál es la velocidad máxima en ciudad?
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <div class="details-option-correct px-3 py-2 rounded-3 border">
                                50 km/h (Correcta)
                            </div>

                            <div class="details-option-normal px-3 py-2 rounded-3 border">
                                70 km/h
                            </div>

                            <div class="details-option-normal px-3 py-2 rounded-3 border">
                                90 km/h
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>`

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

                            <button class="stats-open-btn" onclick="openDetail('${item['id']}', 0)">
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

                            <button class="stats-open-btn" onclick="openDetail('${item['id']}')">
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

    
    let teacherInitials = item.teacher_name
        .split(' ')
        .map(n => n.trim()[0])
        .filter(Boolean)
        .slice(0, 2)
        .join('')
        .toUpperCase();

    let studentInitials = item.student_name
        .split(' ')
        .map(n => n.trim()[0])
        .filter(Boolean)
        .slice(0, 2)
        .join('')
        .toUpperCase();
    
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

}