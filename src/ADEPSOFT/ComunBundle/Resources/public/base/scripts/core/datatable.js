/***
 Wrapper/Helper Class for datagrid based on jQuery Datatable Plugin
 ***/

var Datatable = function () {

    var tableOptions;  // main options
    var dataTable; // datatable object
    var table;    // actual table jquery object
    var tableContainer;    // actual table container object
    var tableWrapper; // actual table wrapper jquery object
    var tableInitialized = false;
    var ajaxParams = []; // set filter mode
    var formEdit;
    var modalEdit;
    //var checkeds = [];
    var extraParam = [];
    var extraData = [];
    var urlEdit;
    var filtered = false;
    var firstPetition = true;

    var countSelectedRecords = function() {
        var selecteds = $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', table);
        var selected = selecteds.size();
        //var selected = checkeds.length;
        var text = tableOptions.dataTable.oLanguage.sGroupActions;
        //table.prop('checkeds',checkeds.join(","));
        //table.attr('checkeds',checkeds.join(","));
        if (selected > 0) {
            $('.table-group-actions > span', tableWrapper).text(text.replace("_TOTAL_", selected+(selected > 1 ? " seleccionados": " seleccionado")));
        } else {
            $('.table-group-actions > span', tableWrapper).text("");
        }
    }

    return {

        //main function to initiate the module
        init: function (options) {

            if (!$().dataTable) {
                return;
            }

            var the = this;

            // default settings
            options = $.extend(true, {
                src: "",  // actual table
                filterApplyAction: "filter",
                filterCancelAction: "filter_cancel",
                resetGroupActionInputOnSuccess: true,
                dataTable: {
                    //"sDom" : "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><t><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>r>>", // datatable layout
                    "sDom" : "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>r>>",
                    "aLengthMenu": [ // set available records per page
                        [10, 20, 30],
                        [10, 20, 30] // change per page values here
                    ],
                    "iDisplayLength": 10, // default records per page
                    "oLanguage": {  // language settings
                        "sProcessing": '<img src="'+GLOBAL.loadingSpinner+'"/><span>&nbsp;&nbsp;Cargando datos...</span>',
                        "sLengthMenu": "<span class='seperator'>|</span>Ver _MENU_ elementos",
                        "sInfo": "<span class='seperator'>|</span>Encontrados _TOTAL_ elementos",
                        "sInfoEmpty": "No hay resultados a mostrar",
                        "sGroupActions": "_TOTAL_",
                        "sAjaxRequestGeneralError": "No se pudo completar la operación.",
                        "sEmptyTable":  "No hay datos.",
                        "sZeroRecords": "No se encontraron resultados.",
                        "sInfoFiltered": "",//"(de un total de _MAX_)",
                        "oPaginate": {
                            "sPrevious": "Anterior",
                            "sNext": "Siguente",
                            "sPage": "Página",
                            "sPageOf": "de"
                        }
                    },

                    "bAutoWidth": false,   // disable fixed width and enable fluid table
                    "bSortCellsTop": true, // make sortable only the first row in thead
                    "sPaginationType": "bootstrap_extended", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
                    "bProcessing": true, // enable/disable display message box on record load
                    "bServerSide": true, // enable/disable server side ajax loading
                    "sAjaxSource": "", // define ajax source URL 
                    "sServerMethod": "POST",

                    // handle ajax request
                    "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {

                        oSettings.jqXHR = $.ajax( {
                            "dataType": 'json',
                            "type": "POST",
                            "url": sSource,
                            "data": aoData,
                            "success": function(res, textStatus, jqXHR) {
                                var type= res.success == true ? 'success' : 'error';
                                //if(res.checkeds.length > 0) {
                                //    for(var i = 0; i < res.checkeds.length;i++){
                                //        if ($.inArray(res.checkeds[i], checkeds) == -1) {
                                //            checkeds.push(res.checkeds[i]);
                                //        }
                                //    }
                                //}
                                if(res.extraData && res.extraData.length > 0) {
                                    the.extraData = res.extraData;
                                }
                                if (res.sMessage) {
                                    var type= res.success == true ? 'success' : 'error';
                                    App.toast(null,res.sMessage,{type:type});
                                    //App.alert({type: (res.sStatus == 'OK' ? 'success' : 'danger'), icon: (res.sStatus == 'OK' ? 'check' : 'warning'), message: res.sMessage, container: tableWrapper, place: 'prepend'});
                                }
                                else if(res.success)
                                    App.toast(null,Mensajes.OpOK,TOAST.SUCCESS);
                                else if(res.success == false)
                                    App.toast(null,Mensajes.OpError,TOAST.ERROR);
                                if (res.success) {
                                    if (tableOptions.resetGroupActionInputOnSuccess) {
                                        $('.table-group-action-input', tableWrapper).val("");
                                    }
                                }
                                if ($('.group-checkable', table).size() === 1) {
                                    $('.group-checkable', table).attr("checked", false);
                                    $.uniform.update($('.group-checkable', table));
                                }
                                if (tableOptions.onSuccess) {
                                    tableOptions.onSuccess.call(the);
                                }
                                fnCallback(res, textStatus, jqXHR);
                            },
                            "error": function(res, textStatus, jqXHR) {
                          //      alert(1);
                                if (jqXHR==="Unauthorized" || jqXHR==="Not Found"){
                                    App.toast("Ha ocurrido un error de permisos, por seguridad sera redirigido a la pantalla de inicio",Mensajes.OpError,TOAST.ERROR);
                                       window.location.href = "http://148.234.110.253/app.php/";
                                    
                                }

                                if (tableOptions.onError) {
                                    tableOptions.onError.call(the);
                                }
                                //App.toast(null,tableOptions.dataTable.oLanguage.sAjaxRequestGeneralError,{type:"error"});
                                //App.alert({type: 'danger', icon: 'warning', message: tableOptions.dataTable.oLanguage.sAjaxRequestGeneralError, container: tableWrapper, place: 'prepend'});
                                $('.dataTables_processing', tableWrapper).hide();
                            }
                        } );
                    },

                    // pass additional parameter
                    "fnServerParams": function ( aoData ) {
                        /* var selecteds = $('tbody > tr > td:nth-child(2) input[type="checkbox"]:checked', table);
                         var values ={};
                         values['checked']=new Array();
                         //var values = new Array();
                         var count = selecteds.size();*/
                        //var count = checkeds.length;
                        //
                        //for(var i = 0; i < count;i++) {
                        //    aoData.push({"name" : "checked[]", "value": checkeds[i]});
                        //}

                        //var form = tableContainer.closest('form');
                        //var id = $('input[type="hidden"][name="id"]',form).val();
                        //if(typeof(id) != 'undefined')
                        //    aoData.push({"id" : param.name, "value": id});

                        //aoData.push({"name" : "firstPetition", "value": firstPetition});
                        //firstPetition=false;
                        for(var i in extraParam) {
                            var param = extraParam[i];
                            aoData.push({"name" : param.name, "value": param.value});

                        }
                        if(the.isFiltered()) {
                            var filter = the.getFitlers();
                            //the.setFiltered();
                            the.addAjaxParam('filter', JSON.stringify(filter));
                        }
                        for(var i in ajaxParams) {
                            var param = ajaxParams[i];
                            aoData.push({"name" : param.name, "value": param.value});

                        }
                    },

                    "fnDrawCallback": function( oSettings ) { // run some code on table redraw
                        if (tableInitialized === false) { // check if table has been initialized
                            tableInitialized = true; // set table initialized
                            table.show(); // display table
                        }
                        table._fnInitComplete(oSettings);
                        App.initUniform($('input[type="checkbox"]', table));  // reinitialize uniform checkboxes on each table reload
                        //marcar los que vengan del server marcados
                        //$('tbody > tr > td:nth-child(2) input[type="checkbox"]', table).each(function(i,e){
                        //    var check = $(e);
                        //    if($.inArray(parseInt(e.value),checkeds) != -1) {
                        //        check.parent().addClass('checked');
                        //        check.attr('checked',true);
                        //    }
                        //});
                        countSelectedRecords(); // reset selected records indicator
                        //$('.dataTables_processing', tableWrapper).remove();
                    }
                }
            }, options);

            tableOptions = options;

            // create table's jquery object
            table = $(options.src);
            tableContainer = table.parents(".table-container");

            // apply the special class that used to restyle the default datatable
            $.fn.dataTableExt.oStdClasses.sWrapper = $.fn.dataTableExt.oStdClasses.sWrapper + " dataTables_extended_wrapper";

            // initialize a datatable
            dataTable = table.dataTable(options.dataTable);
            function fnFormatDetails ( oTable, nTr )
            {
                //var aData = oTable.fnGetData( nTr );
                var count =the.extraData[nTr._DT_RowIndex].length;
                var sOut = '<table>';
                for(var i = 0; i < count;i++)
                {
                    if(the.extraData[nTr._DT_RowIndex][i].name != '#twig')
                        sOut += '<tr><td><b>'+the.extraData[nTr._DT_RowIndex][i].name+'</b></td><td>'+the.extraData[nTr._DT_RowIndex][i].value+'</td></tr>';
                    else
                        return the.extraData[nTr._DT_RowIndex][i].value;
                }

                sOut += '</table>';

                return sOut;
            }


            /* Add event listener for opening and closing details
             * Note that the indicator for showing which row is open is not controlled by DataTables,
             * rather it is done here
             */
            table.on('click', ' tbody td .detalles_elemento', function () {
                var tr = $(this).parents('tr');
                var nTr = tr[0];
                if ( dataTable.fnIsOpen(nTr) )
                {
                    /* This row is already open - close it */
                    tr.removeClass("bold");
                    $('i',$(this)).addClass("fa-eye").removeClass("fa-eye-slash");
                    dataTable.fnClose( nTr );
                }
                else
                {
                    /* Open this row */
                    tr.addClass("bold");
                    $('i',$(this)).addClass("fa-eye-slash").removeClass("fa-eye");
                    dataTable.fnOpen( nTr, fnFormatDetails(dataTable, nTr), 'datatable_detail_element' );
                }
            });

            tableWrapper = table.parents('.dataTables_wrapper');

            // modify table per page dropdown input by appliying some classes
            $('.dataTables_length select', tableWrapper).addClass("form-control input-xsmall input-sm");

            // build table group actions panel
            if ($('.table-actions-wrapper', tableContainer).size() === 1) {
                $('.table-group-actions', tableWrapper).html($('.table-actions-wrapper', tableContainer).html()); // place the panel inside the wrapper
                $('.table-actions-wrapper', tableContainer).remove(); // remove the template container
            }
            // handle group checkboxes check/uncheck
            $('.group-checkable', table).change(function () {
                var set = $('tbody > tr > td:nth-child(1) input[type="checkbox"]', table);
                var checked = $(this).is(":checked");
                $(set).each(function () {
                    $(this).attr("checked", checked);
                    //if(checked == true) {
                    //    var val = parseInt(this.value);
                    //    if ($.inArray(val, checkeds) == -1)
                    //        checkeds.push(val);
                    //}
                    //else
                    //{
                    //    var val = parseInt(this.value);
                    //    var index = $.inArray(val,checkeds);
                    //    if (index != -1)
                    //        checkeds.splice(index,1);
                    //}
                });
                $.uniform.update(set);
                countSelectedRecords();
            });

            // handle row's checkbox click
            table.on('change', 'tbody > tr > td:nth-child(1) input[type="checkbox"]', function(e){
                //var id = $(this).closest('tr').attr('id').split("_")[1];
                //var id = e.target.value;
                //var idInt = parseInt(id);
                //var parent = $(e.target).parent();
                //if($.inArray(idInt,checkeds) == -1) {
                //    if( parent.hasClass('checked')){
                //        checkeds.push(idInt);
                //    }
                //}
                //else
                //{
                //    if( !parent.hasClass('checked')){
                //        var index = $.inArray(idInt,checkeds);
                //        if(index != -1)
                //            checkeds.splice(index, 1);
                //        //checkeds.push(id);
                //    }
                //}
                countSelectedRecords();
            });

            table.on('keypress', '.form-filter', function(e){
                if (e.which == 13) {
                    $('.filter-submit', table).click();
                }
                if (e.which == 0) {
                    $('.filter-cancel', table).click();
                }
            });
            // handle filter submit button click
            table.on('click', '.filter-submit', function(e){
                e.preventDefault();

                the.addAjaxParam("sAction", tableOptions.filterApplyAction);
                if(typeof (e.filter) == 'undefined')//sino pasaron un parametro extra en el evento click es que no fue invocado desde otro lugar que no sea dando el lcick explicitamente
                    the.setFiltered(true);
                //if(the.isFiltered()) {
                //    var filter = the.getFitlers();
                //    //the.setFiltered();
                //    the.addAjaxParam('filter', JSON.stringify(filter));
                //}
                dataTable.fnDraw();
                the.clearAjaxParams();
            });
            // handle filter cancel button click
            table.on('click', '.filter-cancel', function(e){
                the.setFiltered(false);
                e.preventDefault();
                var filtroAvanzadoContainer = $("#"+table.attr('id')+"_before_table");

                $('textarea.form-filter, select.form-filter, input.form-filter', table).each(function(){
                    $(this).val("");
                });
                $('textarea.form-filter, select.form-filter, input.form-filter[type!="radio"]', filtroAvanzadoContainer).each(function(){
                    $(this).val("");
                });

                $('select.form-filter', table).each(function(){
                    $(this).val("").trigger('change');
                });
                $('select.form-filter', filtroAvanzadoContainer).each(function(){
                    $(this).val("").trigger('change');
                });

                $('input.form-filter[type="checkbox"]', table).each(function(){
                    $(this).parent().removeClass('checked');
                });
                $('input.form-filter[type="checkbox"]', filtroAvanzadoContainer).each(function(){
                    $(this).parent().removeClass('checked');
                });

                the.addAjaxParam("sAction", tableOptions.filterCancelAction);
                the.clearAjaxParams();
                dataTable.fnDraw();
            });
        },

        getSelectedRowsCount: function() {
            return $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', table).size();
            //return checkeds.length;
        },

        getSelectedRows: function() {
            var rows = [];
            $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', table).each(function(){
                rows.push({name: $(this).attr("name"), value: $(this).val()});
            });
            //for(var i = 0; i < checkeds.length; i++)
            //    rows.push({name: 'selected[]', value: checkeds[i]});
            return rows;
        },
        setExtraParam: function(extraParams){
            extraParam = extraParams;
        },
        getExtraParam: function(){
            return extraParam;
        },
        setUrlEdit: function(url){
            urlEdit = url;
        },
        setFormEdit: function(id){
            formEdit = id;
        },
        addAjaxParam: function(name, value) {
            ajaxParams.push({"name": name, "value": value});
        },

        clearAjaxParams: function(name, value) {
            ajaxParams = [];
        },

        getDataTable: function() {
            return dataTable;
        },

        getTableWrapper: function() {
            return tableWrapper;
        },

        gettableContainer: function() {
            return tableContainer;
        },

        getTable: function() {
            return table;
        },
        getAjaxParams: function() {
            return ajaxParams;
        },
        isFiltered: function() {
            return filtered;
        },
        setFiltered:function(isFiltered){
            filtered=isFiltered;
        },
        getSimpleFilters: function(){
            var filter = {};
            // get all typeable inputs
            $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function(){
                //the.addAjaxParam($(this).attr("name"), $(this).val());
                var nombre = $(this).attr("name");
                filter[nombre]=$(this).val();
            });
            //$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function(){
            //    //the.addAjaxParam($(this).attr("name"), $(this).val());
            //    var nombre = $(this).attr("name");
            //    filter[nombre]=$(this).val();
            //});
            //$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function(){
            //    //the.addAjaxParam($(this).attr("name"), $(this).val());
            //    var nombre = $(this).attr("name");
            //    filter[nombre]=$(this).val();
            //});
            return filter;
        },
        getFitlers: function(){

            var filter = {};
            // get all typeable inputs
            $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function(){
                //the.addAjaxParam($(this).attr("name"), $(this).val());
                var nombre = $(this).attr("name");
                filter[nombre]=$(this).val();
            });
            //$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function(){
            //    //the.addAjaxParam($(this).attr("name"), $(this).val());
            //    var nombre = $(this).attr("name");
            //    filter[nombre]=$(this).val();
            //});
            //$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function(){
            //    //the.addAjaxParam($(this).attr("name"), $(this).val());
            //    var nombre = $(this).attr("name");
            //    filter[nombre]=$(this).val();
            //});

            var filtroAvanzadoContainer = $("#"+table.attr('id')+"_before_table");
            $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])',filtroAvanzadoContainer ).each(function(){
                //the.addAjaxParam($(this).attr("name"), $(this).val());
                var nombre = $(this).attr("name");
                filter[nombre]=$(this).val();
            });

            $('input.form-filter[type="checkbox"]:checked, input.form-filter[type="radio"]:checked', filtroAvanzadoContainer).each(function(){
                //the.addAjaxParam($(this).attr("name"), $(this).val());
                //filter.push({'name':$(this).attr("name"), 'value':$(this).val()})
                var nombre = $(this).attr("name");
                filter[nombre]=$(this).val();
            });
            return filter;
        }
        //getCheckeds: function() {
        //    return checkeds;
        //}

    };

};
