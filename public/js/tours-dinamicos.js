document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('tour-selector')) {
            const card = e.target.closest('.tour-item');
            const dynamic = card.querySelector('.tour-dynamic-fields');
            const nombre = e.target.options[e.target.selectedIndex].dataset.nombre;

            dynamic.innerHTML = '';

            if (!nombre) return;

            const nombreLower = nombre.toLowerCase();

            if (['machupicchu full day', 'machupicchu conexión', 'machupicchu 2d/1n', 'machupicchu by car'].includes(nombreLower)) {
                dynamic.innerHTML = renderMachupicchuFields();
            }

            if (['valle sagrado', 'city tour', 'valle sur', 'maras moray', 'valle sagrado vip'].includes(nombreLower)) {
                dynamic.innerHTML = renderBoletoTuristicoFields();
            }
        }
    });
});

function renderMachupicchuFields() {
    return `
        <div class="border rounded p-3 bg-light">
            <h6 class="text-danger mb-2"><i class="fas fa-mountain"></i> Detalles Machupicchu</h6>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="form-label">¿Hay entrada?</label>
                    <select class="form-select" name="tours[${index}][detalles_machu][hay_entrada]">
                        <option value="">-- Seleccionar --</option>
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Tipo de Entrada</label>
                    <select class="form-select" name="tours[${index}][detalles_machu][tipo_entrada]">
                        <option value="">-- Seleccionar --</option>
                        <option value="circuito1">Circuito 1</option>
                        <option value="circuito2">Circuito 2</option>
                        <option value="circuito3">Circuito 3</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Horario de Entrada</label>
                    <input type="time" class="form-control" name="tours[${index}][detalles_machu][horario_entrada]">
                </div>
            </div>
        </div>
    `;
}

function renderBoletoTuristicoFields() {
    return `
        <div class="border rounded p-3 bg-light">
            <h6 class="text-success mb-2"><i class="fas fa-ticket-alt"></i> Detalles Boleto Turístico</h6>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Tipo de Boleto</label>
                    <select class="form-select" name="tours[${index}][detalles_boleto][tipo_boleto]">
                        <option value="">-- Seleccionar --</option>
                        <option value="Integral">Integral</option>
                        <option value="Parcial">Parcial</option>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">¿Requiere compra?</label>
                    <select class="form-select" name="tours[${index}][detalles_boleto][requiere_compra]">
                        <option value="">-- Seleccionar --</option>
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>
    `;
}