/**
 * Created with JetBrains PhpStorm.
 * User: Julio
 * Date: 26/02/15
 * Time: 14:34
 * To change this template use File | Settings | File Templates.
 */




function eventNotifierCalendar(eventos){
    if (eventos.total>0)
    {
        $("#eventsCalendarNotifier").html('<span class="badge">'+eventos.total+"</span>");
        $("#eventsCalendarToday").html("Usted tiene "+eventos.total+ " eventos hoy.");
        $("#events").html("");
        if (eventos.enCurso !=null)
            for(var i=0;i<eventos.enCurso.length;i++)
            {
                if (eventos.enCurso[i].termino>95)
                    $("#events").append('<li><a href="#"><span class="task"><span class="desc">'+eventos.enCurso[i].nombre+' </span><span class="percent">'+eventos.enCurso[i].termino+'%</span></span>'+
                        '<span class="progress"><span style="width: '+eventos.enCurso[i].termino+'%;" class="progress-bar progress-bar-danger" aria-valuenow="'+eventos.enCurso[i].termino+'" aria-valuemin="0" aria-valuemax="100">'+
                        '<span class="sr-only">'+eventos.enCurso[i].termino+'% Complete </span></span></span></a></li>');
                else if (eventos.enCurso[i].termino<=0)
                    $("#events").append('<li><a href="#"><span class="task"><span class="desc">'+eventos.enCurso[i].nombre+' </span><span class="percent">No Comenzado</span></span>'+
                        '<span class="progress"><span style="width:1%;" class="progress-bar progress-bar-info" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">'+
                        '<span class="sr-only">No Comenzado </span></span></span></a></li>');
                else
                    $("#events").append('<li><a href="#"><span class="task"><span class="desc">'+eventos.enCurso[i].nombre+' </span><span class="percent">'+eventos.enCurso[i].termino+'%</span></span>'+
                        '<span class="progress"><span style="width: '+eventos.enCurso[i].termino+'%;" class="progress-bar progress-bar-success" aria-valuenow="'+eventos.enCurso[i].termino+'" aria-valuemin="0" aria-valuemax="100">'+
                        '<span class="sr-only">'+eventos.enCurso[i].termino+'% Complete </span></span></span></a></li>');
            }
        if (eventos.nuevos !=null)
            for(var i=0;i<eventos.nuevos.length;i++)
            {
                if (eventos.nuevos[i].termino>95)
                    $("#events").append('<li><a href="#"><span class="task"><span class="desc">'+eventos.nuevos[i].nombre+' </span><span class="percent">'+eventos.nuevos[i].termino+'%</span></span>'+
                        '<span class="progress"><span style="width: '+eventos.nuevos[i].termino+'%;" class="progress-bar progress-bar-danger" aria-valuenow="'+eventos.nuevos[i].termino+'" aria-valuemin="0" aria-valuemax="100">'+
                        '<span class="sr-only">'+eventos.nuevos[i].termino+'% Complete </span></span></span></a></li>');
                else if (eventos.nuevos[i].termino<=0)
                    $("#events").append('<li><a href="#"><span class="task"><span class="desc">'+eventos.nuevos[i].nombre+' </span><span class="percent">No Comenzado</span></span>'+
                        '<span class="progress"><span style="width: 1%;" class="progress-bar progress-bar-info" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">'+
                        '<span class="sr-only">No Comenzado </span></span></span></a></li>');
                else
                    $("#events").append('<li><a href="#"><span class="task"><span class="desc">'+eventos.nuevos[i].nombre+' </span><span class="percent">'+eventos.nuevos[i].termino+'%</span></span>'+
                        '<span class="progress"><span style="width: '+eventos.nuevos[i].termino+'%;" class="progress-bar progress-bar-success" aria-valuenow="'+eventos.nuevos[i].termino+'" aria-valuemin="0" aria-valuemax="100">'+
                        '<span class="sr-only">'+eventos.nuevos[i].termino+'% Complete </span></span></span></a></li>');
            }
    }
    else
        $("#eventsCalendarNotifier").html("");

}



function eventNotifierPendingTasks(eventos){
    if (eventos.total>0)
    {
        $("#pendingTaskNotifier").html('<span class="badge">'+eventos.total+"</span>");
        $("#pendingTasks").html("Usted tiene "+eventos.total+ " tareas pendientes.");
        $("#pendingTaskEvent").html("");
        for(var i=0;i<eventos.total;i++)
            $("#pendingTaskEvent").append('<li><a href="#"><span class="label label-sm label-icon label-success"><i class="fa fa-plus"></i></span>'+eventos.data[i].nombre+
            '. <span class="time">hace 3 dias</span></a></li>');
    }
    else
        $("#pendingTaskNotifier").html("");

}