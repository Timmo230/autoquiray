const paramsDeLaUrl = new URLSearchParams(window.location.search);
const idDetectado = paramsDeLaUrl.get('id');

const quizApp = {
    currentStep: 0,
    totalSteps: 0,
    userAnswers: {},
    testId: idDetectado,

    init: function(total) {
        this.totalSteps = total;
        this.userAnswers = {};
    },

    changeStep: function(n) {
        document.getElementById(`${this.currentStep}`).style.display = 'none';
        this.currentStep += n;
        document.getElementById(`${this.currentStep}`).style.display = 'block';
        window.scrollTo(0, 0);
    },

    saveAnswer: function(qId, oId) {
        quizApp.userAnswers[qId] = oId;
        console.log("Guardado:", quizApp.userAnswers);
    },

    finishTest: async function(qId){
        const respondidas = Object.keys(quizApp.userAnswers).length;

        if (respondidas < quizApp.totalSteps) {
            if (!confirm(`Solo has respondido ${respondidas} de ${quizApp.totalSteps}. ¿Quieres finalizar?`)) {
                return;
            }
        }
        
        const post = await fetch('/autoquiray/resultados', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                responds: quizApp.userAnswers,
                testId: this.testId
            })
        });
        
        console.log("Enviando respuestas:", quizApp.userAnswers);
        if(post.ok){
            window.location.href = `/autoquiray/resultados?id=${this.testId}`;
        }
        else alert('Error al guardar el test');
    },

    time: function(seconds, totalSeconds){
        actualTime = totalSeconds - seconds;
        const timeObject = document.getElementById('timer-display');
        const cociente = Math.floor(actualTime / 60);
        const resto = actualTime % 60;
        const add01 = cociente < 10 ? '0' : '';
        const add02 = resto < 10 ? '0' : '';

        timeObject.textContent = add01 + cociente + ':' + resto + add02;
        return;
    }
};

window.saveAnswer = (qId, oId) => quizApp.saveAnswer(qId, oId);
window.finishTest = () => quizApp.finishTest();
window.changeStep = (n) => quizApp.changeStep(n);