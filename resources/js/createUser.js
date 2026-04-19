let tuitionCountInput = null;
let hiddenCount = null;
let container = null;

let userType = null;
let form = null;
let nameUser = null;
let email = null;
let documentType = null;
let documentValue = null;
let setTitions = null;
let setSalary = null;

let permissionsGot = '';
let types = '';

let perms = null;
let typesGot = null;

const inputSalary = `
        <label class="form-label">Salario (€)</label>
        <input
            type="number"
            name="salary"
            id="salaryID"
            class="form-control form-control-lg"
            min="0"
            step="0.01"
            placeholder="0.00"
            required
        />
    `
const inputTuitions = `
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="rubik mb-0">Matrículas</h5>
        <div class="d-flex gap-2 align-items-center">
            <label class="form-label mb-0">Cantidad</label>
            <input
                id="tuitionCount"
                type="number"
                min="1"
                max="20"
                class="form-control form-control-lg"
                style="width: 110px"
                value="1"
            />
            <input type="hidden" name="tuitions_count" id="tuitions_count_hidden" value="1">
        </div>
    </div>

    <p class="text-muted mt-2 mb-0">
        Al elegir la cantidad se habilitarán los campos de cada matrícula.
    </p>

    <hr class="my-4">

    <div id="tuitionsContainer"></div>
`

function tuitionCard(i) {
    return `
        <div class="border rounded-4 p-4 mb-3 tution">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="rubik">Matrícula #${i + 1}</div>
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
                </div>

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
                </div>
            </div>
        </div>
    `;
}

function renderTuitions() {
    if (!tuitionCountInput || !hiddenCount || !container) return;

    let n = parseInt(tuitionCountInput.value ?? '0', 10);
    if (Number.isNaN(n) || n < 1) n = 1;
    if (n > 20) n = 20;

    tuitionCountInput.value = String(n);
    hiddenCount.value = String(n);

    container.innerHTML = '';
    for (let i = 0; i < n; i++) {
        container.insertAdjacentHTML('beforeend', tuitionCard(i));
    }
}

function prepareArrays() {
    permissionsGot = '<option value="" disabled selected>Selecciona un permiso...</option>';
    types = '<option value="" disabled selected>Selecciona un tipo...</option>';

    (perms || []).forEach(perm => {
        permissionsGot += `<option value="${perm.id}">${perm.permission}</option>`;
    });

    (typesGot || []).forEach(type => {
        types += `<option value="${type.id}">${type.type}</option>`;
    });

    if (userType) {
        userType.innerHTML = types;
    }
}

async function uploadData(e) {
    e.preventDefault();

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const userTypeInput = userType.value;
    const nameUserInput = nameUser.value.trim();
    const emailInput = email.value.trim();
    const documentTypeInput = documentType.value;
    const documentValueInput = documentValue.value.trim();

    let amountTutions = null;
    let tuitionsData = null;

    let salaryValue = null;

    if(userType.value == '1'){
        amountTutions = tuitionCountInput ? parseInt(tuitionCountInput.value, 10) : 0;
        tuitionsData = [];

        if (container) {
            const tutions = container.getElementsByClassName('tution');

            for (let i = 0; i < tutions.length; i++) {
                const t = tutions[i];

                const permission = t.querySelector('select[name^="tuitions"][name$="[permission_id]"]')?.value ?? '';
                const start = t.querySelector('input[name$="[starts_at]"]')?.value ?? '';
                const end = t.querySelector('input[name$="[ends_at]"]')?.value ?? '';
                const price = t.querySelector('input[name$="[price]"]')?.value ?? '';
                const paid = t.querySelector('input[name$="[is_paid]"]')?.checked ?? false;

                tuitionsData.push({
                    permission_id: permission,
                    starts_at: start,
                    ends_at: end,
                    price: price,
                    is_paid: paid
                });
            }
        }
    }
    else salaryValue = document.getElementById("salaryID").value;
    

    try {
        const post = await fetch('/create_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                userType: userTypeInput,
                nameUser: nameUserInput,
                email: emailInput,
                documentType: documentTypeInput,
                documentValue: documentValueInput,
                amountTutions: amountTutions,
                tuitions: tuitionsData,
                salary: salaryValue
            })
        });

        if (post.ok) {
            const payload = await post.json().catch(() => ({}));
            window.showAppFlash?.('success', payload.message ?? 'Usuario creado correctamente.', { persist: true });
            window.location.href = '/create_user';
            return;
        }

        let errorText = 'Error al guardar el usuario';

        try {
            const errorJson = await post.json();
            if (errorJson.message) {
                errorText = errorJson.message;
            }
        } catch (_) {}

        window.showAppFlash?.('error', errorText);
    } catch (error) {
        console.error(error);
        window.showAppFlash?.('error', 'Error de conexión al guardar el usuario');
    }
}

function ContentLoaded() {
    form = document.getElementById('createUserForm');
    userType = document.getElementById('userType');
    nameUser = document.getElementById('name');
    email = document.getElementById('email');
    documentType = document.getElementById('documentType');
    documentValue = document.getElementById('documentValue');

    setTitions = document.getElementById('tuitions');
    setSalary = document.getElementById('salary');

    prepareArrays();
    
    userType.addEventListener('change', function () {
        if (this.value == '1') {
            setTitions.classList.replace("d-none", "d-block");
            setTitions.innerHTML = inputTuitions;

            setSalary.classList.replace("d-block", "d-none");
            setSalary.innerHTML = '';

            tuitionCountInput = document.getElementById('tuitionCount');
            hiddenCount = document.getElementById('tuitions_count_hidden');
            container = document.getElementById('tuitionsContainer');

            tuitionCountInput.addEventListener('input', renderTuitions);
                
            
            renderTuitions();
        } else {
            setTitions.classList.replace("d-block", "d-none");
            setTitions.innerHTML = '';

            setSalary.classList.replace("d-none", "d-block");
            setSalary.innerHTML = inputSalary;

            setTitions.innerHTML = '';
            tuitionCountInput = null;
            hiddenCount = null;
            container = null;
        }
    });
    

    form.addEventListener('submit', uploadData);
}

window.renderTuitions = renderTuitions;
window.ContentLoaded = ContentLoaded;
