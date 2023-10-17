    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!fila) {
            Object.keys(fila).map(k => {
                var row = fila[k]
                events.push({ id: row.id, title: row.fecha, start: row.fecha, end: row.hora });
            })
        }
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

            calendar = new Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                locale: 'es', //Idioma Español FullCalendar
                headerToolbar: {
                    left: 'prev,next today',
                    right: 'dayGridMonth,dayGridWeek,list',
                    center: 'title',
                },
            selectable: true,
            themeSystem: 'bootstrap',
           
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var id = info.event.id
                if (!!fila[id]) {
                    _details.find('#fecha').text(fila[id].fecha)
                    _details.find('#nombre').text(fila[id].nombre)
                    _details.find('#name').text(fila[id].name)
                    _details.find('#estado').text(fila[id].estado)
                    _details.find('#hora').text(fila[id].hora)
                    _details.modal('show')
                } else {
                    alert("Event is undefined");
                }
            },
            eventDidMount: function(info) {
           
            },
            editable: true
        });

        calendar.render();

       
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })


    })