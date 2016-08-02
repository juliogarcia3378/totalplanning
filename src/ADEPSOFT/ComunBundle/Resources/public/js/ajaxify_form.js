$(document).ready(function(){

    function postForm( $form, callback ){

        /*
         * Get all form values
         */
        var values = {};
        $.each( $form.serializeArray(), function(i, field) {
            if(typeof(values[field.name]) == 'object')
                values[field.name].push(field.value);
            else if(typeof(values[field.name]) != 'undefined')
            {
                var tmp = values[field.name];
                values[field.name] = new Array();
                values[field.name].push(tmp);
                values[field.name].push(field.value);
            }
            else
                values[field.name] = field.value;
        });

        $(".input-img-ace").each( function( index, field) {
            if(typeof(values[field.name]) == 'object'){
                values[field.name].push(field.src);
            }else if(typeof(values[field.name]) != 'undefined')
            {
                var tmp = values[field.name];
                values[field.name] = new Array();
                values[field.name].push(tmp);
                values[field.name].push(field.src);
            }
            else
                values[field.name] = field.src;
        });

        if($form.attr('type')=='tree')
        {
            var tree = $("#"+$form.prop('treeId')).jstree(true);
            var checked =tree.get_selected();
            values['checked'] = new Array();
            var count = checked.length;
            for(var i = 0; i < count;i++) {
                if(checked[i] != -1 && tree.is_leaf(checked[i]))
                    values['checked'].push(checked[i].split("_")[1]);
            }
        }
        if($form.attr('type')=='table')
        {
            var table = $('table',$form);
            var selecteds = table.attr('checkeds').split(",");
            //var checked = $("#"+$form.prop('tableId')).jstree(true).get_selected();
            values['checked[]'] = new Array();
            var count = selecteds.length;
            for(var i = 0; i < count;i++) {
                values['checked[]'].push(selecteds[i]);
            }
        }
        /*
         * Throw the form values to the server!
         */
        $.ajax({
            type        : $form.attr( 'method' ),
            url         : $form.attr( 'action' ),
            data        : values,
            success     : function(data) {
                //$(".ajax_form");
                callback( data,$form );
            },
            beforeSend: function(){
                //$(".ajax_form_block").block({message:"Cargando..."});
                if(typeof($form.attr('redirect')) != 'undefined')
                    App.startPageLoading();
                else
                    App.blockUI( { target:".ajax_form_block",inconOnly:true });
            },
            complete: function(){
                if(typeof($form.attr('redirect')) != 'undefined') {
                    App.stopPageLoading();
                    App.fixContentHeight(); // fix content height
                    App.initAjax(); // initialize core stuff
                }
                else
                    App.unblockUI('.ajax_form_block');
                //$(".ajax_form_block").unblock();
            },
            error: function(){
                if(typeof($form.attr('redirect')) != 'undefined') {
                    App.stopPageLoading();
                    App.fixContentHeight(); // fix content height
                    App.initAjax(); // initialize core stuff
                }
                else
                    App.unblockUI('.ajax_form_block');
                //$(".ajax_form_block").unblock();
            }
        });

    }
    $('table[type="dataTable"][init="false"]').each(function(i,e){
        var objT = $(e);
        var id = objT.attr('id');
        objT.attr('init',true);
        TableAjax.init(id,$(e).attr('extra_actions'),JSON.parse($(e).attr('extra_params')));
        $("#"+id+"_modal_create").on('hidden.bs.modal', function () {
            var form = $("#"+id+"_new_form");
            var inputModified = $("input[name='modified']",form);
            if(inputModified.val()=='true') {
                $("#"+id+"_new_form input[name='modified']").val("false");
                $('.filter-submit',$(e)).trigger({type:'click','filter':false});
                //$("#"+id).dataTable().fnDraw();
            }
            //inputModified.detach();
            //form[0].reset();
            //$('textarea, input[type!="hidden"]', form).each(function(){
            //    $(this).val("");
            //});
            //$('select.select2me[allowreset!="false"]', form).select2("val","").trigger("change");
            //$('input[type="checkbox"]', form).each(function(){
            //    var este = $(this);
            //    var value = este.attr('value');
            //    if(value != 'true')
            //        value='false';
            //    este.prop('checked',value);
            //    $.uniform.update(este);
            //});
            //$('input.form-filter[type="checkbox"]', form).each(function(){
            //    $(this).parent().removeClass('checked');
            //});
        });
    });
    $('.ajax_form').each(function(i,e){
        $(e).on('submit',function(e2){
            e2.preventDefault();
            var formObj = $(this);
            if(formObj.valid()) {
                postForm(formObj, function (res, $form) {
                    var redirect = $form.attr('redirect');
                    //alert('paco');
                    if (res.success == true && typeof($form.attr('redirect')) == 'undefined') {
                        var inputId = $("#"+ $(e).attr('id')+' input[name="id"][type="hidden"]');
                        if(typeof(inputId) != 'undefined' && typeof(res.text) != 'undefined')//Si hay un input llamado id entonces estoy editando en lugar de creando por tanto hay que modificar y no crear un elemento nuevo en un tree
                        {
                            var inputText ='<input type="hidden" name="nodeText" value="'+res.text+'"/>';
                            $form.append(inputText);
                        }
                        /**
                         * Si me devuelven un id estoy creando en lugar de editando
                         * entonces tendria que poner el input con el id para que al cerrar el modal
                         * se coja el id y se cree el nodo con ese id
                         */
                        if(typeof(res.id) != 'undefined' && typeof(res.text) != 'undefined'){
                            var inputText ='<input type="hidden" name="id" value="'+res.id+'"/>';
                            inputId  ='<input type="hidden" name="nodeText" value="'+res.text+'"/>';//verificar esto en el create del menu
                            $form.append(inputText);
                            $form.append(inputId);
                        }

                        var input = $("#" + $(e).attr('id') + " input[name='modified']");
                        if (typeof(input) != 'undefined')
                            input.val("true");
                        if(typeof(res.reload) != 'undefined' && res.reload == false)
                            input.val("false");
                        var modal = $(e).closest('.modal');
                        if(modal && typeof(res.html) == 'undefined')
                            modal.modal('toggle');
                        else if(modal)
                        {
                            $("#" + $form.attr('id') + "_container").html(res.html);
                            App.initAjax($form);
                        }
                        if (typeof(res.sMessage) != 'undefined' && res.sMessage != '') {
                            App.toast(null, res.sMessage, TOAST.SUCCESS);
                        }
                        else
                            App.toast(null, Mensajes.OpOK, TOAST.SUCCESS);
                    }
                    else if(res.success == true && typeof($form.attr('redirect')) != 'undefined')
                    {
                        if (typeof(res.sMessage) != 'undefined') {
                            App.toast(null, res.sMessage, TOAST.SUCCESS);
                        }
                        else
                            App.toast(null, Mensajes.OpOK, TOAST.SUCCESS);

                        var pageContentBody = $('.page-content .page-content-body');
                        pageContentBody.html(res.html);
                    }
                    else {
                        if(typeof($form.attr('redirect')) != 'undefined' && typeof(res.reload) == 'undefined')
                        {
                            var pageContentBody = $('.page-content .page-content-body');
                            pageContentBody.html(res);
                            if (typeof(res.sMessage) != 'undefined') {
                                App.toast(null, res.sMessage, TOAST.ERROR);
                            }
                            //else
                            //    App.toast(null, Mensajes.OpError, TOAST.ERROR);
                            App.initAjax();
                        }
                        else
                        {
                            if( typeof(res.errors) != 'undefined')
                            {
                                for(var error in res.errors)
                                {
                                    var group =  $(error).closest('.form-group');
                                    group.addClass('has-error');
                                    var span = '<span class="help-block text-right">'+res.errors[error]+'</span>';
                                    group.append(span);
                                }
                            }
                            if(typeof(res.sMessage) != 'undefined' && res.success == false) {
                                App.toast(null, res.sMessage, TOAST.ERROR);
                                return;
                            }
                            if(typeof(res.reload) != 'undefined') {//EL mensaje de una excepcion, no llevaría recargar la página
                                if(typeof(res.sMessage) != 'undefined')
                                    App.toast(null, res.sMessage, TOAST.ERROR);
                                else
                                    App.toast(null, Mensajes.OpError, TOAST.ERROR);
                                return;
                            }
                            $("#" + $form.attr('id') + "_container").html(res.form);
                            App.initAjax($form);
                        }
                    }
                });
            }
            return false;//lolo
        });
    });

});
