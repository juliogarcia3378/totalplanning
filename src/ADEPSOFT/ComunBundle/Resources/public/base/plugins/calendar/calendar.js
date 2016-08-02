var Calendar = function () {


    return {
        //main function to initiate the module
        init: function (array) {
            Calendar.initCalendar(array);
        },

        initCalendar: function (eventos) {
            for(var u=0;u<eventos.length;u++)
                //    eventos[u]["backgroundColor"]=App.getLayoutColorCode('red');
                if (!jQuery().fullCalendar) {
                    return;
                }
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var h = {};
            if (App.isRTL()) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        right: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }
            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            var calendar= $('#calendar').fullCalendar({
                header: h,
                slotMinutes: 15,
                editable: true,
                droppable: true,
                events: eventos,
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    $("#calendario_event_modal").modal('toggle');
                    titulo= $("#adepsoft_comunbundle_evento_calendario_type_denominacion").val();
                    descripcion = $("#adepsoft_comunbundle_evento_calendario_type_descripcion").val();
                    tiempoCompleto= $("#adepsoft_comunbundle_evento_calendario_type_tiempoCompleto").val();
                    addEvent(titulo,descripcion,tiempoCompleto,start,end);
                    calendar.fullCalendar('renderEvent',
                        {
                            title: titulo,
                            start: start,
                            end: end,
                            allDay: tiempoCompleto
                        },
                        true // make the event "stick"
                    );
                },
                eventClick: function(event) {
                    bootbox.dialog({
                        message: "Que acción desea realizar sobre el evento ?",
                        title: "Seleccione la operación a realizar",
                        buttons: {
                            success: {
                                label: "Modificar",
                                className: "blue",
                                callback: function() {
                                    alert("great success");
                                }
                            },
                            danger: {
                                label: "Eliminar",
                                className: "red",
                                callback: function() {
                                    removeCalendarEvent(event.id);
                                }
                            },
                            main: {
                                label: "Cancelar",
                                className: "blue",
                                callback: function() {
                                }
                            }
                        }
                    });
                },
                eventResize: function(event,delta,minuteDelta){

                    addDaysToEvent(event.id,delta,minuteDelta);
                },
                eventDrop: function(event, delta,minuteDelta) {
                    moveStartDayEvent(event.id,delta,minuteDelta);
                }
            });

        }

    };

}();