const quizApp = {
    currentStep: 0,
    totalSteps: 0,
    userAnswers: {},

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

    finishTest: function() {
        const respondidas = Object.keys(this.userAnswers).length;
        if (respondidas < quizApp.totalSteps) {
            if (!confirm(`Solo has respondido ${respondidas} de ${this.totalSteps}. ¿Quieres finalizar?`)) {
                return;
            }
        }
        
        // Aquí puedes hacer el envío final
        console.log("Enviando respuestas:", this.userAnswers);
    }
};

window.saveAnswer = (qId, oId) => quizApp.saveAnswer(qId, oId);
window.finishTest = () => quizApp.finishTest();