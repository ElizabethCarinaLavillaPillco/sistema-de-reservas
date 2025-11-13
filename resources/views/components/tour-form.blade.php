@props(['tours', 'tourData' => [], 'index' => 0])

<div class="card mb-3 shadow-sm tour-item" data-index="{{ $index }}">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <strong>Tour #{{ $index + 1 }}</strong>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.tour-item').remove()">Eliminar</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-2">
                <label class="form-label">Tour *</label>
                <select name="tours[{{ $index }}][tour_id]" class="form-select" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($tours as $t)
                        <option value="{{ $t->id }}" {{ ($tourData['tour_id'] ?? '') == $t->id ? 'selected' : '' }}>
                            {{ $t->nombreTour }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label class="form-label">Fecha</label>
                <input type="date" name="tours[{{ $index }}][fecha]" class="form-control" value="{{ $tourData['fecha'] ?? '' }}">
            </div>

            <div class="col-md-4 mb-2">
                <label class="form-label">Tipo de Servicio</label>
                <select name="tours[{{ $index }}][tipo_tour]" class="form-select">
                    <option value="Grupal" {{ ($tourData['tipo_tour'] ?? '') == 'Privado' ? '' : 'selected' }}>Grupal</option>
                    <option value="Privado" {{ ($tourData['tipo_tour'] ?? '') == 'Privado' ? 'selected' : '' }}>Privado</option>
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label class="form-label">Lugar de Recojo</label>
                <input type="text" name="tours[{{ $index }}][lugar_recojo]" class="form-control" value="{{ $tourData['lugar_recojo'] ?? '' }}">
            </div>

            <div class="col-md-2 mb-2">
                <label class="form-label">Hora</label>
                <input type="time" name="tours[{{ $index }}][hora_recojo]" class="form-control" value="{{ $tourData['hora_recojo'] ?? '' }}">
            </div>

            <div class="col-md-3 mb-2">
                <label class="form-label">Idioma</label>
                <input type="text" name="tours[{{ $index }}][idioma]" class="form-control" value="{{ $tourData['idioma'] ?? '' }}">
            </div>

            <div class="col-md-3 mb-2">
                <label class="form-label">Empresa</label>
                <input type="text" name="tours[{{ $index }}][empresa]" class="form-control" value="{{ $tourData['empresa'] ?? '' }}">
            </div>

            <div class="col-md-2 mb-2">
                <label class="form-label">Precio Unit.</label>
                <input type="number" step="0.01" name="tours[{{ $index }}][precio_unitario]" class="form-control" value="{{ $tourData['precio_unitario'] ?? 0 }}">
            </div>

            <div class="col-md-2 mb-2">
                <label class="form-label">Cantidad</label>
                <input type="number" min="1" name="tours[{{ $index }}][cantidad]" class="form-control" value="{{ $tourData['cantidad'] ?? 1 }}">
            </div>

            <div class="col-md-4 mb-2">
                <label class="form-label">Estado</label>
                <select name="tours[{{ $index }}][estado]" class="form-select">
                    <option value="Programado" {{ ($tourData['estado'] ?? '') == 'Programado' ? 'selected' : '' }}>Programado</option>
                    <option value="Confirmado" {{ ($tourData['estado'] ?? '') == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="Cancelado" {{ ($tourData['estado'] ?? '') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="col-md-12 mb-2">
                <label class="form-label">Observaciones</label>
                <textarea name="tours[{{ $index }}][observaciones]" class="form-control" rows="2">{{ $tourData['observaciones'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>