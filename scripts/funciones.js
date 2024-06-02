// RECARGAR
const reload = document.getElementById("reload");
reload.addEventListener("click", (_) => {
    location.reload();
});

// EDICION DE DATOS
function editardatos() {
    let $formcontrol = document.getElementsByClassName("form-control editable-field");
    for (let i = 0; i < $formcontrol.length; i++) {
        $formcontrol[i].removeAttribute("readonly");
    }
    document.getElementById("save-btn").style.display = "inline-block";
}


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        editable: true,
        selectable: true,
        selectMirror: true,
        allDaySlot: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: {
            url: 'dietas/cargarDietas.php',
            method: 'POST',
            extraParams: {
                correoElectronicoUsuario: '<?php echo obtenerCorreoElectronicoUsuario(); ?>'
            }
        },
        dateClick: function(info) {
            $('#modalAgregarEvento').modal('show');
            $('#start').val(info.dateStr);
        },
        eventClick: function(info) {
            if (confirm("¿Seguro que deseas eliminar este evento?")) {
                console.log('Evento ID:', info.event.id); // Log para verificar el ID del evento
                $.ajax({
                    url: 'dietas/quitarDietas.php',
                    type: 'POST',
                    data: { id: info.event.id },
                    success: function(response) {
                        console.log('Respuesta de PHP:', response); // Log para verificar la respuesta de PHP
                        if (response.trim() === 'success') {
                            info.event.remove(); // Elimina el evento del calendario
                        } else {
                            alert('Error al eliminar el evento.');
                        }
                    },
                    error: function() {
                        alert('Error al eliminar el evento.');
                    }
                });
            }
        }
    });
    calendar.render();
});

// Función para editar datos
function editardatos() {
    document.querySelectorAll('.editable-field').forEach(field => {
        field.removeAttribute('readonly');
    });
    document.getElementById('save-btn').style.display = 'inline-block';
    document.getElementById('edit-btn').style.display = 'none';
}

