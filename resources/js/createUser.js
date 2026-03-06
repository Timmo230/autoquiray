let tuitionCountInput = null;
let hiddenCount = null;
let container = null;

let userType = null;
let form = null;
let nameUser = null;
let email = null;
let documentType = null;
let documentValue = null;

let permissionsGot = '';
let types = '';

function tuitionCard(i){
    return `
        <div class="border rounded-4 p-4 mb-3 tution">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="rubik">Matrícula #${i+1}</div>
                <span class="badge bg-primary-subtle text-primary rounded-pill">Tuition</span>
            </div>

            <div class="row g-3">
                <div class="col-12 row py-3">
                    <div>
                        <label class="form-label">Permiso</label>
                        <select name="tuitions[${i}][permission_id]" class="form-select form-select-lg" required>
                            ${permissionsGot}
                        </select>
                    </div>
                </div>

                <div class="col-12 row">
                    <div class="col-12 col-lg-6 py-3">
                        <label class="form-label">Inicio</label>
                        <input type="date" name="tuitions[${i}][starts_at]" class="form-control form-control-lg" required />
                    </div>
                    <div class="col-12 col-lg-6 py-3">
                        <label class="form-label">Finalización</label>
                        <input type="date" name="tuitions[${i}][ends_at]" class="form-control form-control-lg" required />
                    </div>
                </div>

                <div class="col-12 row py-3">
                    <div class="col-12 col-lg-4">
                        <label class="form-label">Precio (€)</label>
                        <input
                            type="number"
                            name="tuitions[${i}][price]"
                            class="form-control form-control-lg"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                            required
                        />
                    </div>
                </dic>

                <div class="col-12 row py-3">
                    <div class="col-12 col-lg-4">
                        <label class="form-label d-block">Pagado</label>
                        <div class="form-check form-switch mt-2">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                name="tuitions[${i}][is_paid]"
                                value="1"
                                id="paid_${i}"
                            >
                            <label class="form-check-label" for="paid_${i}">Marcar como pagado</label>
                        </div>
                    </div>
                </<div>
            </div>
        </div>
    `;
}

function renderTuitions(){
    if(!tuitionCountInput || !hiddenCount || !container) return;

    let n = parseInt(tuitionCountInput.value ?? '0', 10);
    if (Number.isNaN(n) || n < 1) n = 1;
    if (n > 20) n = 20;

    tuitionCountInput.value = String(n);
    hiddenCount.value = String(n);

    container.innerHTML = '';
    for (let i = 0; i < n; i++){
        container.insertAdjacentHTML('beforeend', tuitionCard(i));
    }
}

function prepareArrays(perms, typesGot){
    permissionsGot = '<option value="" disabled selected>Selecciona un permiso...</option>';
    types = '<option value="" disabled selected>Selecciona un tipo...</option>';

    (perms || []).forEach(perm => {
        permissionsGot += `<option value="${perm.id}">${perm.permission}</option>`;
    });

    (typesGot || []).forEach(type => {
        types += `<option value="${type.id}">${type.type}</option>`
    });

    renderTuitions();
}

async function uploadData(e){
    e.preventDefault();

    let tutions = container.getElementsByClassName('tution');

    let userTypeInput = userType.value;
    let nameUserInput = nameUser.value;
    let emailInput = email.value;
    let documentTypeInput = documentType.value;
    let documentValueInput = documentValue.value;

    let amountTutions = parseInt(tuitionCountInput.value);

    let tuitionsData = [];

    for (let i = 0; i < tutions.length; i++) {

        const t = tutions[i];

        const permission = t.querySelector('select[name^="tuitions"][name$="[permission_id]"]').value;
        const start = t.querySelector('input[name$="[starts_at]"]').value;
        const end = t.querySelector('input[name$="[ends_at]"]').value;
        const price = t.querySelector('input[name$="[price]"]').value;
        const paid = t.querySelector('input[name$="[is_paid]"]').checked;

        tuitionsData.push({
            permission_id: permission,
            starts_at: start,
            ends_at: end,
            price: price,
            is_paid: paid
        });
    }

    const post = await fetch('/autoquiray/create_user', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            userType: userTypeInput,
            nameUser: nameUserInput,
            email: emailInput,
            documentType: documentTypeInput,
            documentValue: documentValueInput,
            amountTutions: amountTutions,
            tuitions: tuitionsData
        })
    });
    
    if(post.ok) window.location.href = `/autoquiray/create_user`;
    else alert('Error al guardar el test');
}

document.addEventListener('DOMContentLoaded', () => {
    tuitionCountInput = document.getElementById('tuitionCount');
    hiddenCount = document.getElementById('tuitions_count_hidden');
    container = document.getElementById('tuitionsContainer');
    
    form = document.getElementById('createUserForm');
    userType = document.getElementById('userType');
    nameUser = document.getElementById('name');
    email = document.getElementById('email');
    documentType = document.getElementById('documentType');
    documentValue = document.getElementById('documentValue');
    

    if (tuitionCountInput) {
        tuitionCountInput.addEventListener('input', renderTuitions);
    }

    form.addEventListener('submit', uploadData);
    userType.innerHTML = types;
    renderTuitions();
});

window.renderTuitions = renderTuitions;