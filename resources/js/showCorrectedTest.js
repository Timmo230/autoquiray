const paramsDeLaUrl = new URLSearchParams(window.location.search);
const idDetectado = paramsDeLaUrl.get('id');

const quizApp = {
    currentStep: 0,
    totalSteps: 0,
    testId: idDetectado,

    init: function(total) {
        this.totalSteps = total;
    },

    changeStep: function(n) {
        document.getElementById(`${this.currentStep}`).style.display = 'none';
        this.currentStep += n;
        document.getElementById(`${this.currentStep}`).style.display = 'block';
        window.scrollTo(0, 0);
    }
};

window.saveAnswer = (qId, oId) => quizApp.saveAnswer(qId, oId);
window.finishTest = () => quizApp.finishTest();
window.changeStep = (n) => quizApp.changeStep(n);