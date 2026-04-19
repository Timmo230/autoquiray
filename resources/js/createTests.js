function initBuilder() {
    const qty = document.getElementById('num_questions').value;
    const wrapper = document.getElementById('questions-wrapper');
    const area = document.getElementById('dynamic-area');

    wrapper.innerHTML = '';
    area.style.display = 'block';

    for (let i = 0; i < qty; i++) {
        wrapper.innerHTML += `
            <div class="question-node animate__animated animate__fadeIn">
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold text-green">Pregunta #${i + 1}</span>
                    <i class="fa-solid fa-circle-question opacity-25"></i>
                </div>
                <div class="mb-4">
                    <input name="questions[${i}][title]" class="form-control input-autoquiray" placeholder="¿Cuál es la respuesta correcta ante...?" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-transparent border-secondary text-white">A</span>
                            <input type="text" name="questions[${i}][options][0]" class="form-control input-autoquiray" required>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-transparent border-secondary text-white">B</span>
                            <input type="text" name="questions[${i}][options][1]" class="form-control input-autoquiray" required>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-transparent border-secondary text-white">C</span>
                            <input type="text" name="questions[${i}][options][2]" class="form-control input-autoquiray">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <label class="small text-green fw-bold mb-2 d-block">SOLUCIÓN</label>
                        <select name="questions[${i}][correct_option]" class="form-select input-autoquiray h-75">
                            <option value="0">Opción A</option>
                            <option value="1">Opción B</option>
                            <option value="2">Opción C</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
    }
    window.scrollTo({ top: area.offsetTop - 50, behavior: 'smooth' });
}

const form = document.getElementById("examForm");

form.addEventListener('submit', (e) => {
    e.preventDefault();
    submit();
});

async function submit(){
    let titleTest = document.getElementById('title').value;
    let typeTest = document.getElementById('type').value;
    let maxTimeTest = document.getElementById('max_time').value;
    let numQuestionsTest = document.getElementById('num_questions').value;

    let questionNodes  = document.getElementsByClassName('question-node');
    
    let questionsArray = Array.from(questionNodes).map(node => {

        const title = node.querySelector('input[name*="[title]"]').value;

        const options = Array.from(
            node.querySelectorAll('input[name*="[options]"]')
        ).map(input => input.value);

        const correctOption = node.querySelector('select').value;

        return {
            title: title,
            options: options,
            correct_option: correctOption
        };
    });
    
    const post = await fetch('/crear_tests', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            titleTest: titleTest,
            typeTest: typeTest,
            maxTimeTest: maxTimeTest,
            numQuestionsTest: numQuestionsTest,
            questionsArray: questionsArray
        })
    });
    
    if(post.ok) {
        const payload = await post.json().catch(() => ({}));
        window.showAppFlash?.('success', payload.message ?? 'Test guardado correctamente.', { persist: true });
        window.location.href = `/crear_tests`;
    }
    else {
        const payload = await post.json().catch(() => ({}));
        window.showAppFlash?.('error', payload.message ?? 'Error al guardar el test');
    }
}
