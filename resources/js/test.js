const paramsDeLaUrl = new URLSearchParams(window.location.search);
const idDetectado = paramsDeLaUrl.get('id');
const safeTrackEvent = (name, props = {}) => {
    if (typeof window.trackEvent === 'function') {
        window.trackEvent(name, props);
    }
};

const quizApp = {
    currentStep: 0,
    totalSteps: 0,
    userAnswers: {},
    testId: idDetectado,
    elapsedTime: 0,

    init: function(total) {
        this.totalSteps = total;
        this.userAnswers = {};
        this.elapsedTime = 0;
        safeTrackEvent('test_started', { test_id: this.testId });
    },

    changeStep: function(n) {
        document.getElementById(`${this.currentStep}`).style.display = 'none';
        this.currentStep += n;
        document.getElementById(`${this.currentStep}`).style.display = 'block';
        window.scrollTo(0, 0);
    },

    saveAnswer: function(qId, oId) {
        const isFirstAnswer = !(qId in quizApp.userAnswers);
        quizApp.userAnswers[qId] = oId;
        if (isFirstAnswer) {
            safeTrackEvent('test_question_answered');
        }
    },

    finishTest: async function(time){
        const respondidas = Object.keys(quizApp.userAnswers).length;

        if (respondidas < quizApp.totalSteps && !time) {
            if (!confirm(`Solo has respondido ${respondidas} de ${quizApp.totalSteps}. ¿Quieres finalizar?`)) {
                return;
            }
        }
        
        const post = await fetch('/resultados', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                responds: quizApp.userAnswers,
                testId: this.testId,
                time: this.elapsedTime
            })
        });
        
        if(post.ok) {
            const data = await post.json();
            safeTrackEvent('test_completed', {
                test_id: String(this.testId),
                score: String(data.note),
                max_score: String(data.max_note),
                answered: String(data.answered),
                duration_seconds: String(this.elapsedTime)
            });
            window.location.href = `/resultados?id=${this.testId}`;
        }
        else {
            safeTrackEvent('test_submit_failed', { test_id: String(this.testId) });
            alert('Error al guardar el test');
        }
    },

    time: function(seconds, totalSeconds){
        this.elapsedTime = seconds;
        actualTime = totalSeconds - seconds;
        
        if(totalSeconds <= seconds){
            quizApp.finishTest(true);
            return;
        }

        const timeObject = document.getElementById('timer-display');
        const cociente = Math.floor(actualTime / 60);
        const resto = actualTime % 60;
        const add01 = cociente < 10 ? '0' : '';
        const add02 = resto < 10 ? '0' : '';

        timeObject.textContent = add01 + cociente + ':' + add02 + resto;
        return;
    }
};

window.saveAnswer = (qId, oId) => quizApp.saveAnswer(qId, oId);
window.finishTest = () => quizApp.finishTest();
window.changeStep = (n) => quizApp.changeStep(n);
