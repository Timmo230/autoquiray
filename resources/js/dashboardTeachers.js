const teacherQuestionModalElement = document.getElementById('questionReplyModal');
const teacherQuestionModalContent = document.getElementById('teacherQuestionModalContent');
const teacherReplyQuestionId = document.getElementById('teacherReplyQuestionId');
const teacherReplyMessage = document.getElementById('teacherReplyMessage');

const teacherQuestionModal = teacherQuestionModalElement
    ? new bootstrap.Modal(teacherQuestionModalElement)
    : null;

const questionMap = new Map(
    (window.teacherQuestions || []).map((question) => [question.id, question])
);

const formatDateTime = (value) => {
    if (!value) {
        return 'Sin fecha';
    }

    const normalized = value.replace(' ', 'T');
    const date = new Date(normalized);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const escapeHtml = (value) => {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
};

const getInitials = (fullName) => {
    if (!fullName) {
        return '??';
    }

    return fullName
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('');
};

const renderAnswerBubble = (answer) => {
    const teacherInitials = getInitials(answer.teacher_name);

    return `
        <div class="details-message-row details-message-row-right">
            <div class="details-message-block">
                <div class="details-user-header details-user-header-right">
                    <div class="details-user-info-right">
                        <div class="details-user-name">${escapeHtml(answer.teacher_name)}</div>
                        <div class="details-user-date">Respondido el ${formatDateTime(answer.date_sent)}</div>
                    </div>
                    <div class="details-avatar details-avatar-teacher">${teacherInitials}</div>
                </div>

                <div class="details-bubble details-bubble-teacher">
                    <div class="details-bubble-label">Respuesta del profesor</div>
                    <p class="mb-0">${escapeHtml(answer.menssage)}</p>
                </div>
            </div>
        </div>
    `;
};

window.openTeacherQuestionModal = (questionId) => {
    const question = questionMap.get(questionId);

    if (!question || !teacherQuestionModalContent || !teacherReplyQuestionId) {
        return;
    }

    const studentInitials = getInitials(question.student_name);
    const answers = Array.isArray(question.answers) ? question.answers : [];
    const answersMarkup = answers.length > 0
        ? answers.map(renderAnswerBubble).join('')
        : `
            <div class="teacher-no-answer-state">
                <i class="fa-regular fa-message"></i>
                <span>Todavia no hay respuestas de profesores en esta consulta.</span>
            </div>
        `;

    teacherQuestionModalContent.innerHTML = `
        <div class="details-card">
            <div class="details-card-header">
                <div class="teacher-question-modal-head">
                    <div>
                        <span class="details-badge">Consulta</span>
                        <h5 class="details-subject mb-1">${escapeHtml(question.affair)}</h5>
                        <p class="details-conversation-label mb-0">
                            Pregunta enviada por ${escapeHtml(question.student_name)} (${escapeHtml(question.student_email)})
                        </p>
                    </div>

                    <div class="teacher-question-modal-stats">
                        <span class="teacher-question-pill">
                            <i class="fa-solid fa-user-group"></i>
                            ${question.teachers_count} profesor${question.teachers_count === 1 ? '' : 'es'}
                        </span>
                        <span class="teacher-question-pill">
                            <i class="fa-solid fa-reply"></i>
                            ${question.answers_count} respuesta${question.answers_count === 1 ? '' : 's'}
                        </span>
                    </div>
                </div>
            </div>

            <div class="details-chat-wrapper">
                <div class="details-message-row details-message-row-left">
                    <div class="details-message-block">
                        <div class="details-user-header">
                            <div class="details-avatar details-avatar-student">${studentInitials}</div>
                            <div>
                                <div class="details-user-name">${escapeHtml(question.student_name)}</div>
                                <div class="details-user-date">Enviado el ${formatDateTime(question.date_sent)}</div>
                            </div>
                        </div>

                        <div class="details-bubble details-bubble-student">
                            <div class="details-bubble-label">Mensaje del alumno</div>
                            <p class="mb-0">${escapeHtml(question.menssage)}</p>
                        </div>
                    </div>
                </div>

                ${answersMarkup}
            </div>
        </div>
    `;

    teacherReplyQuestionId.value = question.id;

    if (!teacherReplyMessage.value.trim()) {
        teacherReplyMessage.value = '';
    }
};

if (window.teacherQuestionAutoOpen && questionMap.has(window.teacherQuestionAutoOpen) && teacherQuestionModal) {
    window.openTeacherQuestionModal(window.teacherQuestionAutoOpen);
    teacherQuestionModal.show();
}
