@if($mode === 'create')
    <form action="{{ route('admin.pasajeros.store') }}" method="POST">
@else
    <form action="{{ route('admin.pasajeros.update', $pasajero->id) }}" method="POST">
        @method('PUT')
@endif
@csrf

<!-- Reserva Asociada -->
<div class="mb-3">
    <label for="reserva_id" class="form-label">Reserva Asociada (opcional)</label>
    <select name="reserva_id" id="reserva_id" class="form-select">
        <option value="">-- Selecciona una reserva --</option>
        @foreach ($reservas as $reserva)
            <option value="{{ $reserva->id }}"
                {{ old('reserva_id', $pasajero->reserva_id ?? '') == $reserva->id ? 'selected' : '' }}>
                #{{ $reserva->id }} - {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}
            </option>
        @endforeach
    </select>
</div>

<!-- Tipo pasajero -->
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="tipo_pasajero" class="form-label">Tipo Pasajero</label>
        <select name="tipo_pasajero" id="tipo_pasajero" class="form-select" required>
            <option value="">-- Selecciona --</option>
            <option value="Peruano" {{ old('tipo_pasajero', $pasajero->tipo_pasajero ?? '') == 'Peruano' ? 'selected' : '' }}>Peruano</option>
            <option value="Extranjero" {{ old('tipo_pasajero', $pasajero->tipo_pasajero ?? '') == 'Extranjero' ? 'selected' : '' }}>Extranjero</option>
            <option value="CAN" {{ old('tipo_pasajero', $pasajero->tipo_pasajero ?? '') == 'CAN' ? 'selected' : '' }}>CAN</option>
        </select>
    </div>

    <!-- Tipo documento -->
    <div class="col-md-4 mb-3">
        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
        <select name="tipo_documento" id="tipo_documento" class="form-select">
            <option value="DNI" {{ old('tipo_documento', $pasajero->tipo_documento ?? '') == 'DNI' ? 'selected' : '' }}>DNI</option>
            <option value="CE" {{ old('tipo_documento', $pasajero->tipo_documento ?? '') == 'CE' ? 'selected' : '' }}>CE</option>
            <option value="Pasaporte" {{ old('tipo_documento', $pasajero->tipo_documento ?? '') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
        </select>
    </div>

    <!-- Documento + Buscar -->
    <div class="col-md-4 mb-3 d-flex align-items-end">
        <input type="text" name="documento" id="documento"
            value="{{ old('documento', $pasajero->documento ?? '') }}"
            class="form-control me-2" placeholder="N° Documento" required>
        <button type="button" id="buscar" class="btn btn-secondary" disabled>Buscar</button>
    </div>
</div>

<!-- Nombre / Apellido -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre"
            value="{{ old('nombre', $pasajero->nombre ?? '') }}"
            class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" name="apellido" id="apellido"
            value="{{ old('apellido', $pasajero->apellido ?? '') }}"
            class="form-control" required>
    </div>
</div>

<!-- Teléfono + Fecha nacimiento -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
            value="{{ old('fecha_nacimiento', $pasajero->fecha_nacimiento ? $pasajero->fecha_nacimiento-> format('Y-m-d') : '') }}"
            class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
            value="{{ old('telefono', $pasajero->telefono ?? '') }}"
            class="form-control">
    </div>
    
</div>

<!-- Países + Ciudad -->
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="pais_nacimiento" class="form-label">País de nacimiento</label>
        <input type="text" name="pais_nacimiento" id="pais_nacimiento"
            value="{{ old('pais_nacimiento', $pasajero->pais_nacimiento ?? '') }}"
            class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="pais_residencia" class="form-label">País de residencia</label>
        <input type="text" name="pais_residencia" id="pais_residencia"
            value="{{ old('pais_residencia', $pasajero->pais_residencia ?? '') }}"
            class="form-control" required>
    </div>
    <div class="col-md-4 mb-3" id="ciudadDiv">
        <label for="ciudad" class="form-label">Ciudad</label>
        <input type="text" name="ciudad" id="ciudad"
            value="{{ old('ciudad', $pasajero->ciudad ?? '') }}"
            class="form-control">
    </div>
</div>



<!-- Tarifa (solo lectura) -->
<div class="mb-3">
    <label for="tarifa" class="form-label">Tarifa asignada</label>
    <input type="text" id="tarifa" class="form-control"
        value="{{ $pasajero->tarifa ?? 'Se asignará automáticamente' }}" readonly>
</div>

<!-- BOTONES -->
<div class="d-flex gap-3 mt-4">
    <button type="submit" class="btn btn-primary btn-lg">
        {{ $mode === 'create' ? 'Registrar Pasajero' : 'Actualizar Pasajero' }}
    </button>
    <a href="{{ route('admin.pasajeros.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
</div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tipoPasajero = document.getElementById("tipo_pasajero");
        const tipoDocumento = document.getElementById("tipo_documento");
        const buscarBtn = document.getElementById("buscar");
        const ciudadDiv = document.getElementById("ciudadDiv");

        // Opciones posibles
        const opciones = {
            Peruano: ["DNI", "CE"],
            Extranjero: ["Pasaporte", "DNI"],
            CAN: ["Pasaporte", "DNI"]
        };

        function actualizarOpciones() {
            const seleccionado = tipoPasajero.value;

            // limpiar opciones actuales
            tipoDocumento.innerHTML = "";

            if (seleccionado && opciones[seleccionado]) {
                opciones[seleccionado].forEach(doc => {
                    const option = document.createElement("option");
                    option.value = doc;
                    option.textContent = doc;
                    tipoDocumento.appendChild(option);
                });

                // habilitar botón buscar solo para Peruanos
                buscarBtn.disabled = (seleccionado !== "Peruano");
            } else {
                buscarBtn.disabled = true;
            }
        }

        
        function actualizarCampos() {
            const pasajero = tipoPasajero.value;
            const documento = tipoDocumento.value;

            // Mostrar ciudad solo si es peruano
            ciudadDiv.style.display = pasajero === "Peruano" ? "block" : "none";

            // Evento inicial
            tipoPasajero.addEventListener("change", actualizarOpciones);

            // Ejecutar al cargar la página (para que se setee según el valor actual)
            actualizarOpciones();

            // Habilitar botón buscar solo si es peruano con DNI
            if (pasajero === "Peruano" && tipoDocumento.value === "DNI") {
                buscarBtn.disabled = false;
                buscarBtn.classList.remove("btn-secondary");
                buscarBtn.classList.add("btn-success");
            } else {
                buscarBtn.disabled = true;
                buscarBtn.classList.remove("btn-success");
                buscarBtn.classList.add("btn-secondary");
            }
        }

        tipoPasajero.addEventListener("change", actualizarOpciones);
        opciones.addEventListener("change", actualizarOpciones);
        actualizarCampos(); // inicial
    });

    // Lógica de API para el DNI
    document.getElementById("buscar").addEventListener("click", function () {
        let documento = document.getElementById("documento").value;
        fetch("https://apiperu.dev/api/dni/" + documento + "?api_token=TU_TOKEN")
            .then((res) => res.json())
            .then((datos) => {
                if (datos.data) {
                    document.getElementById("nombre").value = datos.data.nombres;
                    document.getElementById("apellido").value = datos.data.apellido_paterno + " " + datos.data.apellido_materno;
                }
            });
    });
</script>
