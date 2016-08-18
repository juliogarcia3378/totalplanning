var TableAjax = function () {

    var initPickers = function () {
        //init date pickers
        //$('.date-picker').datepicker({
        //    rtl: App.isRTL(),
        //    autoclose: true
        //});
    }

    var handleRecords = function(tableId,extraActions) {

        var grid = new Datatable();
        if(arguments.length > 2)
            grid.setExtraParam(arguments[2]);
        var formEdit = tableId+"_edit_form";
        var formDetalles = tableId+"_detalles_form";
        var tableHtml = $("#"+tableId+"[url]");

        var aSorting = [];
        var notSortable = [];//poner atributo en la tabla diciendo si tiene o no check y # para saber donde emepzar el array de disable
        $("#"+tableId+' th').each(function(i,e){
            var th = $(this);
            if(th.attr("sort")=="false"){
                notSortable.push(i);
            }
            if(th.attr('defaultorder')=="true")
            {
                aSorting.push([i,th.attr('sort-order')]);
            }
        });

        grid.init({
            src: $("#"+tableId),
            onSuccess: function(grid) {
            },
            onError: function(grid) {
            },
            dataTable: {  // here you can define a typical datatable settings from http://datatables.net/usage/options
                /*
                 By default the ajax datatable's layout is horizontally scrollable and this can cause an issue of dropdown menu is used in the table rows which.
                 Use below "sDom" value for the datatable layout if you want to have a dropdown menu for each row in the datatable. But this disables the horizontal scroll.
                 */
                //"sDom" : "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>r>>",
                "aLengthMenu": [
                    [10, 15, 25],
                    [10, 15, 25] // change per page values here
                ],
                "bAutoWidth": false,

                //"sScrollX": "100%",
                "iDisplayLength": 10, // default record count per page
                "bServerSide": true, // server side processing
                "sAjaxSource": $("#"+tableId).attr('url'), // ajax source
                bStateSave:false,
                //"sAjaxDataProp": "data",
                //"aoColumnDefs": [
                //    { "sClass": "text-center", "aTargets": [ -1 ] }
                //],
                //"aoColumnDefs": [
                //    { "sWidth": "20%", "aTargets": [ '_all' ] },
                //    { "bAutoWidth": false, "aTargets": [ '_all' ] }
                //],
                "aoColumnDefs" : [{  // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                    'bSortable' : false,
                    'aTargets' : notSortable
                }],
                "aaSorting": aSorting ,// set 3rd column as a default sort by asc
                fnInitComplete: function(oSettings,json){
                    var tableObj = $("#"+oSettings.sTableId);
                    var isModal = tableObj.attr('modal');


                    $("#"+oSettings.sTableId+" .eliminar_elemento").on('click',function(e){
                        e.preventDefault();

                        if (confirm("¿Está seguro que desea eliminar este elemento?") == false) {
                            return;
                        }
                        var nRow = $(this).closest('tr');
                        var nRowId = (nRow).attr('id');
                        var idSplited = nRowId.split("_");
                        nRowId = idSplited[idSplited.length-1];
                        //var param = [{'name':'id','value':(nRow).attr('id')},{name:'action',value:'deleteAjax'}];
                        //ajaxParams = param;
                        grid.addAjaxParam('selected[]',nRowId);
                        grid.addAjaxParam('action','delete');

                        //URL del eliminar
                        oSettings.sAjaxSource = tableHtml.attr('url2');

                        $('.filter-submit', tableObj).trigger({type:'click','filter':false});
                        //grid.getDataTable().fnDeleteRow(nRow);
                        //grid.clearAjaxParams();

                        oSettings.sAjaxSource = tableHtml.attr('url');
                        //ajaxParams = [];
                        //grid.fnDraw();

                        //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
                    });
                    $("#"+oSettings.sTableId+" .editar_elemento").on('click',function(e){
                        e.preventDefault();

                        var nRowId = $(this).closest('tr').attr('id');
                        var idSplited = nRowId.split("_");
                        nRowId = idSplited[idSplited.length-1];
                        var form = null;
                        var modal = null;
                        var rutaEdit=null;

                        if(isModal) {
                            form = $('#' + formEdit);
                            modal = form.closest('.modal');
                            rutaEdit=  form.attr('action')
                        }
                        else
                            rutaEdit = tableObj.attr('rutaedit');
                        //if(!$("#"+oSettings.sTableId).attr('ajax'))
                        //    location.href = form.attr('action')+"?id="+nRowId;
                        //modal.one('shown.bs.modal', function () {
                        //    $(".ajax_form_block").block({message:"Cargando..."});
                        //});

                        var extraP = grid.getExtraParam();
                        extraP.push({'name':'id', 'value':nRowId});
                        $.ajax({
                            type        : "GET",
                            url         : rutaEdit,
                            data        : extraP,
                            success     : function(res) {
                                if(!isModal) {
                                    var pageContentBody = $('.page-content .page-content-body');
                                    //location.href = form.attr('action') + "?id=" + nRowId;
                                    pageContentBody.html(res);
                                    return;
                                }

                                $("#"+formEdit+"_container").html(res.form);
                                if(typeof(res.title) != 'undefined')
                                {
                                    form.closest('modal');
                                    $('h4 b',modal).text(res.title);
                                }
                                //form.attr('action',urlEdit);
                                var inputId ='<input type="hidden" name="id" value="'+nRowId+'"/>';
                                //var inputModified ='<input type="hidden" name="modified" value="false"/>';
                                form.append(inputId);
                                //form.append(inputModified);
                            },
                            beforeSend: function(){
                                if(isModal) {
                                    modal.one('hidden.bs.modal', function () {
                                        $('#' + formEdit + ' input[name="id"][type="hidden"]').detach();

                                        var inputModified = $('#' + formEdit + ' input[name="modified"]');
                                        if (inputModified.val() == 'true') {
                                            inputModified.val('false');
                                            $('.filter-submit', tableObj).trigger({type:'click','filter':false});
                                            //oSettings.oInstance.fnDraw();
                                        }

                                    });
                                    App.blockUI({target: ".page-content", inconOnly: true});
                                }
                                else
                                {
                                    App.scrollTop();
                                    App.startPageLoading();
                                }
                            },
                            complete: function(){
                                // initialize core stuff
                                if(isModal) {
                                    App.unblockUI(".page-content");
                                    modal.modal('toggle');
                                    App.initAjax(form);
                                }
                                else
                                {
                                    App.stopPageLoading();
                                    App.fixContentHeight(); // fix content height
                                    App.initAjax();
                                }
                            }
                        });
                        extraP.pop();
                        //this.off('click');

                        //$('#'+modalEdit).modal('toggle');
                    });
                    //$("#"+oSettings.sTableId+" .detalles_elemento").on('click',function(e){
                    //    e.preventDefault();
                    //    var nRowId = $(this).closest('tr').attr('id');
                    //    nRowId = nRowId.split("_")[1];
                    //    var form = $('#'+formDetalles);
                    //
                    //    var modal = form.closest('.modal');
                    //    //modal.one('shown.bs.modal', function () {
                    //    //    $(".ajax_form_block").block({message:"Cargando..."});
                    //    //});
                    //
                    //    $.ajax({
                    //        type        : "GET",
                    //        url         : form.attr('action'),
                    //        data        : {'id':nRowId},
                    //        success     : function(res) {
                    //            $("#"+formDetalles+"_container").html(res);
                    //        },
                    //        beforeSend: function(){
                    //            App.blockUI( { target:".page-content",inconOnly:true });
                    //            //$(".page-content").block({message:"Cargando..."});
                    //        },
                    //        complete: function(){
                    //            App.unblockUI( ".page-content");
                    //            //$(".page-content").unblock();
                    //            modal.modal('toggle');
                    //        }
                    //    });
                    //
                    //});
                    //extraActions.length = 0;
                    var extraActions = tableObj.attr('extra_actions');
                    if(typeof(extraActions) != 'undefined') {
                        var actions = extraActions.split(",");
                        for (var i = 0; i < actions.length; i++) {
                            //Click elementos con la clase de la accion ejecuta la accion
                            var action = actions[i];
                            if (action.length != 0) {
                                var elem = $("#" + oSettings.sTableId + " ." + action);
                                //para saber si necesita un exportar
                                elem.on('click', function (e) {
                                    var este = $(this);
                                    if(este.attr('noevent') == "false") {
                                        e.preventDefault();
                                        var nRowId = $(this).closest('tr').attr('id');
                                        var idSplited = nRowId.split("_");
                                        nRowId = idSplited[idSplited.length - 1];

                                        var extraP = grid.getExtraParam();
                                        extraP.push({'name': 'id', 'value': nRowId});
                                        if (typeof($(this).attr('url')) != 'undefined') {
                                            var target = App.defaultAjaxContent();
                                            App.loadAjax($(this).attr('url'), target, extraP);
                                            extraP.pop();
                                            return;
                                        }

                                        var form = $("#" + oSettings.sTableId + "_" + $(this).attr('action') + "_form");

                                        var modal = form.closest('.modal');

                                        $.ajax({
                                            type: "GET",
                                            url: form.attr('action'),
                                            data: extraP,
                                            success: function (res) {
                                                $("#" + form.attr('id') + "_container").html(res);
                                                //form.attr('action',urlEdit);
                                                var inputId = '<input type="hidden" name="id" value="' + nRowId + '"/>';
                                                var inputModified = '<input type="hidden" name="modified" value="false"/>';
                                                form.append(inputId);
                                                form.append(inputModified);
                                                modal.one('hidden.bs.modal', function () {
                                                    form.find('input[name="id"][type="hidden"]').detach();
                                                    var inputModified = form.find('input[name="modified"]');

                                                    if (inputModified.val() == 'true') {
                                                        //if (typeof(res.replace) == 'undefined') {
                                                        //    $('.filter-submit', $("#" + oSettings.sTableId)).click(false);
                                                        $('.filter-submit', tableObj).trigger({
                                                            type: 'click',
                                                            'filter': false
                                                        });
                                                        //oSettings.oInstance.fnDraw();
                                                        //}
                                                    }
                                                    inputModified.detach();

                                                });
                                                App.initAjax(form);
                                            },
                                            beforeSend: function () {
                                                //App.blockUI({target: "#" + oSettings.sTableId, inconOnly: true});
                                                App.blockUI({target: ".page-content", inconOnly: true});
                                            },
                                            complete: function () {
                                                App.unblockUI(".page-content");
                                                //App.blockUI( { target:".page-content",inconOnly:true });
                                                modal.modal('toggle');
                                            }
                                        });
                                        extraP.pop();
                                        //this.off('click');

                                        //$('#'+modalEdit).modal('toggle');
                                    }
                                    else{
                                        var nRowId = $(this).closest('tr').attr('id');
                                        var idSplited = nRowId.split("_");
                                        nRowId = idSplited[idSplited.length - 1];
                                        $("#" + oSettings.sTableId + "_" + action+'_form a[name="submit"]').trigger({type:'click', id:nRowId});
                                    }
                                });
                            }
                        }
                        jQuery('.tooltips').tooltip();
                    }
                }

            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function(e){
            e.preventDefault();

            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                var filter=grid.getFitlers();
                grid.addAjaxParam('filter', JSON.stringify(filter));

                grid.addAjaxParam("sAction", "group_action");
                grid.addAjaxParam("action", action.val());
                var records = grid.getSelectedRows();
                for (var i in records) {
                    var idSplited = records[i]["value"].split("_");
                    var nRowId = idSplited[idSplited.length-1];
                    grid.addAjaxParam(records[i]["name"], nRowId);
                }
                if(action.val() == "delete") {

                    //var doit = true;
                    if(grid.getSelectedRowsCount() == 1)
                    {
                        if (confirm("¿Está seguro que desea eliminar este elemento?") == false) {
                            return;
                        }
                        //bootbox.confirm("¿Está seguro que desea eliminar este elemento?",function(result){
                        //    if(result != true)
                        //        doit = false;
                        //});
                    }
                    if(grid.getSelectedRowsCount() > 1)
                    {
                        if (confirm("¿Está seguro que desea eliminar estos elementos?") == false) {
                            return;
                        }
                        //bootbox.confirm("¿Está seguro que desea eliminar estos elementos?",function(result){
                        //    if(result != true)
                        //        doit = false;
                        //});
                    }
                    //if(!doit)
                    //    return ;
                    var oSettings = grid.getTable().fnSettings();
                    oSettings.sAjaxSource = tableHtml.attr('url2');
                    grid.getDataTable().fnDraw();
                    oSettings.sAjaxSource = tableHtml.attr('url');
                    grid.clearAjaxParams();
                }else
                {
                    var oSettings = grid.getTable().fnSettings();
                    oSettings.sAjaxSource = action.attr(action.val()+"_url");
                    grid.getDataTable().fnDraw();
                    oSettings.sAjaxSource = tableHtml.attr('url');
                    grid.clearAjaxParams();
                }
                //else{
                //    var modal = $("#"+tableId+"_modal_"+action.val());
                //    var form = $("#"+tableId+"_"+action.val()+"_form")
                //    $.ajax({
                //        type        : "GET",
                //        url         : form.attr('action'),
                //        data:       grid.getAjaxParams(),
                //        success     : function(res) {
                //            $("#"+form.attr('id')+"_container").html(res.form);
                //            //form.attr('action',urlEdit);
                //            var inputId ='<input type="hidden" name="id" value="'+nRowId+'"/>';
                //            var inputModified ='<input type="hidden" name="modified" value="false"/>';
                //            form.append(inputId);
                //            form.append(inputModified);
                //
                //        },
                //        beforeSend: function(){
                //            modal.one('hidden.bs.modal', function () {
                //                $('#'+formEdit+' input[name="id"][type="hidden"]').detach();
                //
                //                var inputModified = $('#'+formEdit+' input[name="modified"]');
                //                if(inputModified.val()=='true') {
                //                    inputModified.detach();
                //                    oSettings.oInstance.fnDraw();
                //                }
                //                else
                //                    inputModified.detach();
                //
                //            });
                //            App.blockUI( { target:".page-content",inconOnly:true });
                //        },
                //        complete: function(){
                //            App.unblockUI( ".page-content");
                //            modal.modal('toggle');
                //        }
                //    });
                //}

            } else if (action.val() == "") {
                App.alert({type: 'danger', icon: 'warning', message: 'Seleccione una acción.', container: grid.getTableWrapper(), place: 'prepend'});
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({type: 'danger', icon: 'warning', message: 'No hay elementos seleccionados.', container: grid.getTableWrapper(), place: 'prepend'});
            }
        });
        var exportUrl_pdf = $("#"+tableId).attr('export_url_pdf');
        if(typeof(exportUrl_pdf) != 'undefined') {
            $("#" + tableId + "_export").on('click', function () {
                var headers = {};
                $('#'+grid.getTable().attr('id')+'_modal_pdf_export').find('input[type="checkbox"]:checked').each(function(i,e){
                    //the.addAjaxParam($(this).attr("name"), $(this).val());
                    //filter.push({'name':$(this).attr("name"), 'value':$(this).val()})
                    //var nombre = $(this).attr("name");
                    headers["report_field_"+i]=$(this).val();
                });
                var form = $("#"+tableId+"_modal_pdf_export_form");
                $("#"+tableId+" th").each(function(index){
                    if($(this).hasClass('sorting_asc') ) {
                        $('input.order_column',form).val(index);
                        $('input.order_dir',form).val("asc");
                    }
                    else  if($(this).hasClass('sorting_desc')) {
                        $('input.order_column',form).val(index);
                        $('input.order_dir',form).val("desc")
                    }
                });
                var filters = grid.getSimpleFilters();
                $.download(exportUrl_pdf,headers,filters,form);
            });
        }
        var exportUrl_xls = $("#"+tableId).attr('export_url_xls');
        if(typeof(exportUrl_xls) != 'undefined') {
            $("#" + tableId + "_xls_export").on('click', function () {
                var headers = {};
                $('#'+grid.getTable().attr('id')+'_modal_pdf_export').find('input[type="checkbox"]:checked').each(function(i,e){
                    //the.addAjaxParam($(this).attr("name"), $(this).val());
                    //filter.push({'name':$(this).attr("name"), 'value':$(this).val()})
                    //var nombre = $(this).attr("name");
                    headers["report_field_"+i]=$(this).val();
                });
                var form = $("#"+tableId+"_modal_pdf_export_form");
                $("#"+tableId+" th").each(function(index){
                    if($(this).hasClass('sorting_asc') ) {
                        $('input.order_column',form).val(index);
                        $('input.order_dir',form).val("asc");
                    }
                    else  if($(this).hasClass('sorting_desc')) {
                        $('input.order_column',form).val(index);
                        $('input.order_dir',form).val("desc")
                    }
                });
                var filters = grid.getSimpleFilters();
                $.download(exportUrl_xls,headers,filters,form);
            });
        }
        grid.setFormEdit(formEdit);
        //grid.setUrlEdit(urlEdit);

    }

    return {

        //main function to initiate the module
        init: function (tableId,extraActions) {
            //var argumentsArray = Array.prototype.slice.apply(arguments);
            initPickers();
            var extraParams = [];
            if(arguments.length > 2) {
                handleRecords(tableId, extraActions, arguments[2]);
                extraParams=arguments[2];
            }
            else
                handleRecords(tableId,extraActions);

            var tableObj = $("#"+tableId);
            var formNew = tableId+"_new_form";
            var isModal = tableObj.attr('modal') == 1;

            if(!isModal)
            {
                $("#"+tableId+"_page_create").on('click',function(e){
                    var rutanew = tableObj.attr('rutanew')
                    $.ajax({
                        type        : "GET",
                        url         : rutanew,
                        data        : extraParams,
                        success     : function(res) {
                            var pageContentBody = $('.page-content .page-content-body');
                            //location.href = form.attr('action') + "?id=" + nRowId;
                            if(typeof(res.form) !='undefined')
                                pageContentBody.html(res.form);
                            else
                                pageContentBody.html(res);
                        },
                        beforeSend: function(){
                            App.scrollTop();
                            App.startPageLoading();
                        },
                        complete: function(){
                            // initialize core stuff
                            App.stopPageLoading();
                            App.fixContentHeight(); // fix content height
                            App.initAjax();
                        }
                    });
                });
            }else
            {
                $("#"+tableId+"_page_create").on('click',function(e){
                    var modalNew = $("#"+formNew).closest('.modal');
                    $.ajax({
                        type        : "GET",
                        url         : $("#"+formNew).attr('action'),
                        data        : extraParams,
                        success     : function(res) {
                            var formN = $("#"+formNew);
                            $("#"+formNew+"_container").html(res.form);
                            //form.attr('action',urlEdit);
                            for (var i in extraParams) {
                                var param = extraParams [i];
                                formN.append('<input type="hidden" name="'+param.name+'" value="'+param.value+'"/>');
                            }
                            //var inputModified ='<input type="hidden" name="modified" value="false"/>';
                            //formN.append(inputModified);
                        },
                        beforeSend: function(){
                            modalNew.one('hidden.bs.modal', function () {

                                for (var i in extraParams) {
                                    var param = extraParams [i];
                                    $('#' + formNew + ' input[name="'+param.name+'"]').remove();
                                }
                            });
                            App.blockUI({target: ".page-content", inconOnly: true});
                        },
                        complete: function(){
                            // initialize core stuff
                            App.unblockUI(".page-content");
                            modalNew.modal('toggle');
                            App.initAjax($("#"+formNew));
                        }
                    });
                });
            }
        }

    };

}();