document.addEventListener('DOMContentLoaded', function() {
    const selectAsunto = document.getElementById('tipo');
    const contenedorOtro = document.getElementById('otroAsunto');

    selectAsunto.addEventListener('change', function() {
        if(this.value === 'otro') {
            contenedorOtro.innerHTML = `
                <label for="detalle_asunto" class="form-label">Especifique el asunto</label>
                <input type="text" 
                       class="form-control" 
                       id="detalle_asunto" 
                       name="detalle_asunto" 
                       placeholder="¿En qué podemos ayudarte?" 
                       required>
            `;
        }
        else contenedorOtro.innerHTML = '';
    });
})