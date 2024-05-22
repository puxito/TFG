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


// CALENDARIO
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
            // Aquí puedes agregar la funcionalidad para editar eventos
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

