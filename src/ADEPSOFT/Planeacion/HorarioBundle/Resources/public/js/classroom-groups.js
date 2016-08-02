//@ sourceURL=classroom-groups.js

$(document).ready(function() {
    $().dndPageScroll();
    updateClassRooms();
});
function dragstart(ev) {
    ev.dataTransfer.setData("elem", ev.target.id);
    var class_request = ev.target.getAttribute('class');
    var elem = ev.target;
    var request_room_id = elem.parentNode.parentNode.id;
    $('.slot').each(function(ev) {
        var class_target = $(this).attr('accepts');
        if(class_request.search(class_target) !== -1) {
            if ($(this).children().length === 0) {
                var target_room_id = $(this).parent().attr('id');
                if (request_room_id === target_room_id){
                    $(this).addClass('signalize');
                } else {
                    var horas = parseInt(elem.getAttribute('horas'));
                    var htotal = parseInt($(this)[0].parentNode.getAttribute('htotal'));
                    var hactual = parseInt($(this)[0].parentNode.getAttribute('hactual'));
                    if (htotal >= hactual + horas) {
                        $(this).addClass('signalize');
                    }
                }
            }
        }
    });
};
function target_dragover(ev) {
    ev.preventDefault();
};
function target_drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("elem");
    var elem = document.getElementById(data);
    var class_request = elem.getAttribute('class');
    var class_target = ev.target.getAttribute('accepts');
    if(class_request.search(class_target) !== -1) {
        if(tryAssigment(elem, ev)) {
            var level_request = parseInt(elem.getAttribute('nivel'));
            var level_available = parseInt(ev.target.parentNode.getAttribute('capacidad'));
            if (elem.parentNode.className === 'room') {
                elem.parentNode.className = 'slot';
                if (level_request > level_available) {
                    ev.target.className = 'slot_mark';
                }
            }
        }
    }
};
function tryAssigment(elem, ev) {
    var level_request = parseInt(elem.getAttribute('nivel'));
    var level_available = parseInt(ev.target.parentNode.getAttribute('capacidad'));
    var horas = parseInt(elem.getAttribute('horas'));
    var htotal_target = parseInt(ev.target.parentNode.getAttribute('htotal'));
    var hactual_target = parseInt(ev.target.parentNode.getAttribute('hactual'));
    var request_room_id = ev.target.parentNode.id;
    var target_room_id = elem.parentNode.parentNode.id;
    if (request_room_id === target_room_id){
        ev.target.appendChild(elem);
    } else if ((horas + hactual_target) <= htotal_target) {
        hactual_target += horas;
        ev.target.parentNode.setAttribute('hactual',hactual_target);

        if (elem.parentNode.parentNode.className === 'room') {
            elem.parentNode.className = 'slot';
            if (level_request > level_available) {
                ev.target.className = 'slot_mark';
            }
            var htotal_origin = parseInt(elem.parentNode.parentNode.getAttribute('htotal'));
            var hactual_origin = parseInt(elem.parentNode.parentNode.getAttribute('hactual'));
            if (hactual_origin - horas >= 0) {
                elem.parentNode.parentNode.setAttribute('hactual',hactual_origin - horas);
                $(elem.parentNode.parentNode).children().last().html('Horas: ' + (hactual_origin - horas) + '/' + htotal_origin);
            }
        }
        $(ev.target.parentNode).children().last().html('Horas: ' + hactual_target + '/' + htotal_target);
        ev.target.appendChild(elem);
        return true;
    }
    else{
        errorMsg('La cantidad de horas necesarias: <span>' + horas + '</span>, sobrepasa las disponibles: <span>' + (htotal_target - hactual_target) + '</span>');
        return false;
    }
};
function dragend(ev) {
    $('.slot').removeClass('signalize');
};
function swap_drop(ev) {
    ev.preventDefault();
    if(!$(ev.target.parentNode.parentNode).hasClass('lock')){
        var data = ev.dataTransfer.getData("elem");
        var elem = document.getElementById(data);
        //Get Nodes
        var request_group = ev.target.parentNode.parentNode;
        var request_slot = ev.target.parentNode.parentNode.parentNode;
        var target_slot = elem.parentNode;
        var request_fusion = ($(request_group).attr('fusion') === 'true');
        var target_fusion = ($(elem).attr('fusion') === 'true');
        if(request_fusion && target_fusion){
            //Fusionar
        }else{
            var class_request = elem.parentNode.getAttribute('accepts');
            var class_target = ev.target.parentNode.parentNode.parentNode.getAttribute('accepts');
            if(class_request.search(class_target) !== -1) {
                //Get Hours
                var request_hactual = parseInt(request_slot.parentNode.getAttribute('hactual'));
                var request_htotal = parseInt(request_slot.parentNode.getAttribute('htotal'));
                var request_horas = parseInt(request_group.getAttribute('horas'));
                var target_hactual = parseInt(target_slot.parentNode.getAttribute('hactual'));
                var target_htotal = parseInt(target_slot.parentNode.getAttribute('htotal'));
                var target_horas = parseInt(elem.getAttribute('horas'));
                var request_control = request_hactual + target_horas - request_horas;
                var target_control = target_hactual + request_horas - target_horas;
                if ((request_control <= request_htotal) && (target_control <= target_htotal)){
                    var tmp_request_group = $(request_group).detach();
                    var tmp_target_group = $(elem).detach();
                    $(target_slot).append(tmp_request_group);
                    $(request_slot).append(elem);
                    updateClassRooms();
                }else{
                    errorMsg('La distribución de horas clase no permite intercambiar los grupos');
                }
            }
        }
    }
};
function drag(ev) {
    /*Should be used later...*/
};
function group_context_menu(ev) {
    var group = $(ev.target).parent().parent();
    if($(ev.target).hasClass('fa-rotate-90')) {
        $(ev.target).removeClass('fa-rotate-90');
        saveDialog(group);
        $(".group-context-menu").hide();
    }else{
        $('.group-menu').removeClass('fa-rotate-90');
        $(ev.target).addClass('fa-rotate-90');
        var pos = $(ev.target).offset();
        setupDialog(group, pos);
        $(".group-context-menu").show();
    }
};
function group_close(ev) {
    errorMsg('Por implementar');
};
function setupDialog(group, pos) {
    $('#group-context-menu-level').val(group.attr('nivel'));
    var fusion = (group.attr('fusion') === 'true');
    var lock = (group.attr('lock') === 'true');
    var bil = (group.attr('bilingue') === 'true');
    var third = (group.attr('terceros') === 'true');
    var sem = group.attr('semestre');
    var plan = group.attr('plan');
    var h = group.attr('horas');
    $('#group-context-menu-fusion').prop('checked',fusion);
    $('#group-context-menu-lock').prop('checked',lock);
    $('#group-context-menu-bil').prop('checked',bil);
    $('#group-context-menu-third').prop('checked',third);
    $('#group-context-menu-sem').html(sem);
    $('#group-context-menu-plan').html(plan);
    $('#group-context-menu-h').html(h + 'h');
    $('.group-context-menu').css({
        position: 'absolute',
        top: pos.top - 20 + 'px',
        left: pos.left - 5 + 'px'
    });
    $.uniform.update();
};
function saveDialog(group) {
    var lock = $('#group-context-menu-lock').prop('checked');
    group.attr('nivel',$('#group-context-menu-level').val());
    group.attr('fusion',$('#group-context-menu-fusion').prop('checked'));
    group.attr('lock',lock);
    group.attr('bilingue',$('#group-context-menu-bil').prop('checked'));
    group.attr('terceros',$('#group-context-menu-third').prop('checked'));
    var group_level = parseInt(group[0].getAttribute('nivel'));
    var level_available = parseInt(group[0].parentNode.parentNode.getAttribute('capacidad'));
    if (group_level > level_available) {
        group[0].parentNode.className = 'slot_mark';
    } else {
        group[0].parentNode.className = 'slot';
    }
    if (lock){
        if (!$(group).hasClass('lock')) {
            $(group).addClass('lock');
            $(group).attr('draggable','false');
        }
    }
    else{
        $(group).removeClass('lock');
        $(group).attr('draggable','true');
    }
};
function updateClassRooms() {
    $('.room').each(function() {
        var htotal = parseInt($(this).attr('htotal'));
        var cap = parseInt($(this).attr('capacidad'));
        var hsum = 0;
        $(this).find('.group').each(function() {
            hsum += parseInt($(this).attr('horas'));
            var nivel = parseInt($(this).attr('nivel'));
            if (nivel > cap) {
                $(this).parent().removeClass('slot').addClass('slot_mark');
            }	else {
                $(this).parent().removeClass('slot_mark').addClass('slot');
            }
        });
        $(this).children().last().html('Horas: ' + hsum + '/' + htotal);
        $(this).attr('hactual',hsum);
    });
};
function errorMsg(msg){
    $('#error_msg .description').html(msg);
    $('#error_msg .description span:nth-of-type(1)').css({
        'color': 'darkblue',
        'font-weight': 'bold'
    });
    $('#error_msg .description span:nth-of-type(2)').css({
        'color': 'darkred',
        'font-weight': 'bold'
    });
    $('#error_msg').modal('show');
};
function updateLevel(ev){
    ev.target.parentNode.setAttribute('level',ev.target.value);
};
