function iniciarSelectReferente() {
    if ($('#referente_id').length) {
        if ($('#referente_id').hasClass('select2-hidden-accessible')) {
            $('#referente_id').select2('destroy');
        }

        $('#referente_id').select2({
            width: '100%',
            dropdownParent: $('#referente_modal'),
            placeholder: 'Seleccione un referente'
        });
    }
}

function guardarReferenteSeleccionado(padronId) {
    let referenteId = $('#referente_id').val();

    Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
        .call('guardarReferente', padronId, referenteId);
}

function iniciarSelectVehiculo() {
    if ($('#vehiculo_id').length) {

        if ($('#vehiculo_id').hasClass('select2-hidden-accessible')) {
            $('#vehiculo_id').select2('destroy');
        }

        $('#vehiculo_id').select2({
            width: '100%',
            dropdownParent: $('#vehiculo_modal'),
            placeholder: 'Seleccione un vehículo'
        });
    }
}

function guardarVehiculoSeleccionado(padronId) {
    let vehiculoId = $('#vehiculo_id').val();

    if (!vehiculoId) {
        alert('Seleccione un vehículo');
        return;
    }

    Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
        .call('guardarVehiculo', padronId, vehiculoId);
}

function guardarPosicion(padronId) {

    let lat = document.getElementById('latitude')?.value;
    let lng = document.getElementById('longitude')?.value;

    if (!lat || !lng) {
        alert('Seleccione una ubicación en el mapa');
        return;
    }

    Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
        .call('guardarUbicacion', padronId, lat, lng);
}

let map = null;
let marker = null;

window.addEventListener('mostrar-mapa', function () {
    setTimeout(() => {
        let mapDiv = document.getElementById('map');
        if (!mapDiv) return;

        let savedLat = mapDiv.dataset.lat;
        let savedLng = mapDiv.dataset.lng;

        let defaultLat = -25.2637;
        let defaultLng = -57.5759;

        if (map) {
            map.remove();
            map = null;
            marker = null;
        }

        map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        function actualizarInputs(lat, lng) {
            let latInput = document.getElementById('latitude');
            let lngInput = document.getElementById('longitude');

            if (latInput) latInput.value = lat;
            if (lngInput) lngInput.value = lng;
        }

        function ponerOMoverMarcador(lat, lng, texto = null) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: false }).addTo(map);
            }

            if (texto) {
                marker.bindPopup(texto).openPopup();
            }

            actualizarInputs(lat, lng);
        }

        // Siempre permitir cambiar con click
        map.on('click', function (e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            ponerOMoverMarcador(lat, lng);
        });

        // 1. Si tiene ubicación guardada
        if (savedLat && savedLng) {
            let lat = parseFloat(savedLat);
            let lng = parseFloat(savedLng);

            map.setView([lat, lng], 15);
            ponerOMoverMarcador(lat, lng, 'Ubicación guardada');
            return;
        }

        // 2. GPS
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;

                    map.setView([lat, lng], 15);
                    ponerOMoverMarcador(lat, lng, 'Tu ubicación actual');
                },
                function () {
                    map.setView([defaultLat, defaultLng], 13);
                    ponerOMoverMarcador(defaultLat, defaultLng, 'Ubicación por defecto');
                }
            );
        } else {
            map.setView([defaultLat, defaultLng], 13);
            ponerOMoverMarcador(defaultLat, defaultLng, 'Ubicación por defecto');
        }
    }, 200);
});


$(document).ready(function () {
    $('#referente_modal').on('shown.bs.modal', function () {
        iniciarSelectReferente();
    });

    $('#vehiculo_modal').on('shown.bs.modal', function () {
        iniciarSelectVehiculo();
    });
});

window.addEventListener('close-modal', function () {
    $('#referente_modal').modal('hide');
    $('#vehiculo_modal').modal('hide');
});
