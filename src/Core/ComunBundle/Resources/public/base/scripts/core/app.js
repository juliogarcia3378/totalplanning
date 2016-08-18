/**
 Core script to handle the entire theme and core functions
 **/
var App = function () {

    // IE mode
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;

    var sidebarWidth = 225;
    var sidebarCollapsedWidth = 35;

    var responsiveHandlers = [];

    // theme layout color set
    var layoutColorCodes = {
        'blue': '#4b8df8',
        'red': '#e02222',
        'blue': '#35aa47',
        'purple': '#852b99',
        'grey': '#555555',
        'light-grey': '#fafafa',
        'yellow': '#ffb848'
    };

    // To get the correct viewport width based on  http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
    var _getViewPort = function () {
        var e = window, a = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return {
            width: e[a + 'Width'],
            height: e[a + 'Height']
        }
    }

    // initializes main settings
    var handleInit = function () {

        if ($('body').css('direction') === 'rtl') {
            isRTL = true;
        }

        isIE8 = !! navigator.userAgent.match(/MSIE 8.0/);
        isIE9 = !! navigator.userAgent.match(/MSIE 9.0/);
        isIE10 = !! navigator.userAgent.match(/MSIE 10.0/);

        if (isIE10) {
            jQuery('html').addClass('ie10'); // detect IE10 version
        }

        if (isIE10 || isIE9 || isIE8) {
            jQuery('html').addClass('ie'); // detect IE10 version
        }

        /*
         Virtual keyboards:
         Also, note that if you're using inputs in your modal – iOS has a rendering bug which doesn't
         update the position of fixed elements when the virtual keyboard is triggered
         */
        var deviceAgent = navigator.userAgent.toLowerCase();
        if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
            $(document).on('focus', 'input, textarea', function () {
                $('.page-header').hide();
                $('.page-footer').hide();
            });
            $(document).on('blur', 'input, textarea', function () {
                $('.page-header').show();
                $('.page-footer').show();
            });
        }
    }

    var handleSidebarState = function () {
        // remove sidebar toggler if window width smaller than 992(for tablet and phone mode)
        var viewport = _getViewPort();
        if (viewport.width < 992) {
            $('body').removeClass("page-sidebar-closed");
        }
    }

    // runs callback functions set by App.addResponsiveHandler().
    var runResponsiveHandlers = function () {
        // reinitialize other subscribed elements
        for (var i = 0; i < responsiveHandlers.length; i++) {
            var each = responsiveHandlers[i];
            each.call();
        }
    }

    // reinitialize the laypot on window resize
    var handleResponsive = function () {
        handleSidebarState();
        handleSidebarAndContentHeight();
        handleFixedSidebar();
        runResponsiveHandlers();
    }

    // initialize the layout on page load
    var handleResponsiveOnInit = function () {
        handleSidebarState();
        handleSidebarAndContentHeight();
    }

    // handle the layout reinitialization on window resize
    var handleResponsiveOnResize = function () {
        var resize;
        if (isIE8) {
            var currheight;
            $(window).resize(function () {
                if (currheight == document.documentElement.clientHeight) {
                    return; //quite event since only body resized not window.
                }
                if (resize) {
                    clearTimeout(resize);
                }
                resize = setTimeout(function () {
                    handleResponsive();
                }, 50); // wait 50ms until window resize finishes.                
                currheight = document.documentElement.clientHeight; // store last body client height
            });
        } else {
            $(window).resize(function () {
                if (resize) {
                    clearTimeout(resize);
                }
                resize = setTimeout(function () {
                    handleResponsive();
                }, 50); // wait 50ms until window resize finishes.
            });
        }
    }

    //* BEGIN:CORE HANDLERS *//
    // this function handles responsive layout on screen size resize or mobile device rotate.

    // Set proper height for sidebar and content. The content and sidebar height must be synced always.
    var handleSidebarAndContentHeight = function () {
        var content = $('.page-content');
        var sidebar = $('.page-sidebar');
        var body = $('body');
        var height;

        if (body.hasClass("page-footer-fixed") === true && body.hasClass("page-sidebar-fixed") === false) {
            var available_height = $(window).height() - $('.footer').outerHeight() - $('.header').outerHeight();
            if (content.height() < available_height) {
                content.attr('style', 'min-height:' + available_height + 'px !important');
            }
        } else {
            if (body.hasClass('page-sidebar-fixed')) {
                height = _calculateFixedSidebarViewportHeight();
            } else {
                height = sidebar.height() + 20;
                if ($(window).width() > 1024 && height < $(window).height()) {
                    height = $(window).height() - $('.footer').outerHeight() - $('.header').outerHeight();
                }
            }
            if (height >= content.height()) {
                content.attr('style', 'min-height:' + height + 'px !important');
            }
        }
    }
    var handleTimePickers = function () {
        var context = ".page-content";
        if(arguments.length > 0)
            context = arguments[0];
        if (jQuery().timepicker) {
            $('.timepicker-default',context).timepicker({
                autoclose: true,
                showSeconds: true,
                minuteStep: 1
            });

            $('.timepicker-no-seconds',context).timepicker({
                autoclose: true,
                minuteStep: 5
            });

            $('.timepicker-24',context).timepicker({
                autoclose: true,
                minuteStep: 5,
                showSeconds: false,
                defaultTime:false,
                showMeridian: false
            });

            // handle input group button click
            $('.timepicker',context).parent('.input-group').on('click', '.input-group-btn', function(e){
                e.preventDefault();
                $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
            });
        }
    }

    var handleAjaxLinks = function(){
        // handle ajax link within main content
        //jQuery('.page-content').on('click', '.ajaxify', function (e) {
        //    e.preventDefault();
        //    App.scrollTop();
        //
        //    var url = $(this).attr("href");
        //    var pageContent = $('.page-content');
        //    var pageContentBody = $('.page-content .page-content-body');
        //
        //    App.startPageLoading();
        //
        //    if ($(window).width() <= 991 && $('.page-sidebar').hasClass("in")) {
        //        $('.navbar-toggle').click();
        //    }
        //
        //    $.ajax({
        //        type: "GET",
        //        cache: false,
        //        url: url,
        //        dataType: "html",
        //        success: function (res) {
        //            App.stopPageLoading();
        //            pageContentBody.html(res);
        //            App.fixContentHeight(); // fix content height
        //            App.initAjax(); // initialize core stuff
        //        },
        //        error: function (xhr, ajaxOptions, thrownError) {
        //            pageContentBody.html('<h4>Se detuvo la carga del contenido.</h4>');
        //            App.stopPageLoading();
        //        }
        //    });
        //});
        //jQuery('.dropdown-menu').on('click', '.ajaxify', function (e) {
        //    e.preventDefault();
        //    App.scrollTop();
        //
        //    var url = $(this).attr("href");
        //    var pageContent = $('.page-content');
        //    var pageContentBody = $('.page-content .page-content-body');
        //
        //    App.startPageLoading();
        //
        //    if ($(window).width() <= 991 && $('.page-sidebar').hasClass("in")) {
        //        $('.navbar-toggle').click();
        //    }
        //
        //    $.ajax({
        //        type: "GET",
        //        cache: false,
        //        url: url,
        //        dataType: "html",
        //        success: function (res) {
        //            App.stopPageLoading();
        //            pageContentBody.html(res);
        //            App.fixContentHeight(); // fix content height
        //            App.initAjax(); // initialize core stuff
        //        },
        //        error: function (xhr, ajaxOptions, thrownError) {
        //            pageContentBody.html('<h4>Se detuvo la carga del contenido.</h4>');
        //            App.stopPageLoading();
        //        }
        //    });
        //});
        var context = ".page-content";
        if(arguments.length > 0)
            context = arguments[0];
        $(' .ajaxify',context).on('click', function (e) {
            e.preventDefault();
            App.scrollTop();

            var url = $(this).attr("href");

            var pageContent = $('.page-content');
            var pageContentBody = $('.page-content .page-content-body');
            var defaultTarget=true;
            if($(e.currentTarget).attr('target') && $(e.currentTarget).attr('target') != ".page-content .page-content-body") {
                pageContentBody = $($(e.currentTarget).attr('target'));
                defaultTarget = false;
            }

            var block = pageContentBody;
            if($(e.currentTarget).attr('block'))
                block =$(e.currentTarget).attr('block');
            if(block == 'form_block')
                block = $(e.currentTarget).closest('.ajax_form_block');

            App.blockUI({target:block});

            if ($(window).width() <= 991 && $('.page-sidebar').hasClass("in")) {
                $('.navbar-toggle').click();
            }
            var dataType = 'html';
            if($(e.currentTarget).attr('type') == 'json')
                dataType = 'json';
            $.ajax({
                type: "GET",
                cache: false,
                url: url,
                dataType:dataType,
                success: function (res) {
                    if(typeof(res.success) != 'undefined') {
                        if (res.success == true) {
                            if (typeof(res.sMessgae) == 'undefined')
                                App.toast(null, Mensajes.OpOK, TOAST.SUCCESS);
                            else
                                App.toast(null, res.sMessgae, TOAST.SUCCESS);
                        }
                        else {
                            if (typeof(res.sMessgae) == 'undefined')
                                App.toast(null, Mensajes.OpError, TOAST.ERROR);
                            else
                                App.toast(null, res.sMessgae, TOAST.ERROR);
                        }
                        pageContentBody.html(res.html);
                    }
                    else {

                        pageContentBody.html(res);
                    }
                    App.unblockUI(block);
                    App.fixContentHeight(); // fix content height
                    //if(arguments.length > 0)
                    //    App.initAjax(arguments[0]);
                    //else
                    if(defaultTarget)
                        App.initAjax();
                    else
                        App.initAjax(pageContentBody);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    pageContentBody.html('<h4>No se pudo cargar el contenido.</h4>');
               
                    App.toast("Ha ocurrido un error de permisos, por seguridad sera redirigido a la pantalla de inicio",Mensajes.OpError,TOAST.ERROR);
                    window.location.href = "http://148.234.110.253/app.php/";
                    App.unblockUI(block);
                }
            });
        });
    }
    // Handle sidebar menu
    var handleSidebarMenu = function () {
        jQuery('.page-sidebar').on('click', 'li > a', function (e) {
            if ($(this).next().hasClass('sub-menu') == false) {
                if ($('.btn-navbar').hasClass('collapsed') == false) {
                    $('.btn-navbar').click();
                }
                return;
            }

            if ($(this).next().hasClass('sub-menu always-open')) {
                return;
            }

            var parent = $(this).parent().parent();
            var the = $(this);
            var menu = $('.page-sidebar-menu');
            var sub = jQuery(this).next();

            var autoScroll = menu.data("auto-scroll") ? menu.data("auto-scroll") : "true"   ;
            var slideSpeed = menu.data("slide-speed") ? parseInt(menu.data("slide-speed")) : 200;

            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(200);
            parent.children('li.open').removeClass('open');

            var slideOffeset = -200;

            if (sub.is(":visible")) {
                jQuery('.arrow', jQuery(this)).removeClass("open");
                jQuery(this).parent().removeClass("open");
                sub.slideUp(slideSpeed, function () {
                    if (autoScroll == "true" && $('body').hasClass('page-sidebar-closed') == false) {
                        if ($('body').hasClass('page-sidebar-fixed')) {
                            menu.slimScroll({'scrollTo': (the.position()).top});
                        } else {
                            App.scrollTo(the, slideOffeset);
                        }
                    }
                    handleSidebarAndContentHeight();
                });
            } else {
                jQuery('.arrow', jQuery(this)).addClass("open");
                jQuery(this).parent().addClass("open");
                sub.slideDown(slideSpeed, function () {
                    if (autoScroll == "true" && $('body').hasClass('page-sidebar-closed') == false) {
                        if ($('body').hasClass('page-sidebar-fixed')) {
                            menu.slimScroll({'scrollTo': (the.position()).top});
                        } else {
                            App.scrollTo(the, slideOffeset);
                        }
                    }
                    handleSidebarAndContentHeight();
                });
            }

            e.preventDefault();
        });

        // handle ajax links within sidebar menu
        jQuery('.page-sidebar').on('click', ' li > a.ajaxify', function (e) {
            e.preventDefault();
            App.scrollTop();

            var url = $(this).attr("href");
            var menuContainer = jQuery('.page-sidebar ul');
            var pageContent = $('.page-content');
            var pageContentBody = $('.page-content .page-content-body');

            menuContainer.children('li.active').removeClass('active');
            menuContainer.children('.arrow.open').removeClass('open');

            $(this).parents('li').each(function () {
                $(this).addClass('active');
                $(this).children('a span.arrow').addClass('open');
                $(this).children('a').append('<span class="selected"></span>')
            });
            $(this).parents('li').addClass('active');

            App.startPageLoading();

            if ($(window).width() <= 991 && $('.page-sidebar').hasClass("in")) {
                $('.navbar-toggle').click();
            }

            $.ajax({
                type: "GET",
                cache: false,
                url: url,
                dataType: "html",
                success: function (res) {
                    App.stopPageLoading();
                    pageContentBody.html(res);
                    App.fixContentHeight(); // fix content height
                    App.initAjax(); // initialize core stuff
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    pageContentBody.html('<h4>No se pudo realizar la operaci&oacute;n</h4>');
                    App.toast("Ha ocurrido un error de permisos, por seguridad sera redirigido a la pantalla de inicio",Mensajes.OpError,TOAST.ERROR);
                       window.location.href = "http://148.234.110.253/app.php/";
                  
                    App.stopPageLoading();
                }
            });
        });

        //handleAjaxLinks();
    }

    // Helper function to calculate sidebar height for fixed sidebar layout.
    var _calculateFixedSidebarViewportHeight = function () {
        var sidebarHeight = $(window).height() - $('.header').height() + 1;
        if ($('body').hasClass("page-footer-fixed")) {
            sidebarHeight = sidebarHeight - $('.footer').outerHeight();
        }

        return sidebarHeight;
    }

    // Handles fixed sidebar
    var handleFixedSidebar = function () {
        var menu = $('.page-sidebar-menu');

        if (menu.parent('.slimScrollDiv').size() === 1) { // destroy existing instance before updating the height
            menu.slimScroll({
                destroy: true
            });
            menu.removeAttr('style');
            $('.page-sidebar').removeAttr('style');
        }

        if ($('.page-sidebar-fixed').size() === 0) {
            handleSidebarAndContentHeight();
            return;
        }

        var viewport = _getViewPort();
        if (viewport.width >= 992) {
            var sidebarHeight = _calculateFixedSidebarViewportHeight();

            menu.slimScroll({
                size: '7px',
                color: '#a1b2bd',
                opacity: .3,
                position: isRTL ? 'left' : 'right',
                height: sidebarHeight,
                allowPageScroll: false,
                disableFadeOut: false
            });
            handleSidebarAndContentHeight();
        }
    }

    // Handles the sidebar menu hover effect for fixed sidebar.
    var handleFixedSidebarHoverable = function () {
        if ($('body').hasClass('page-sidebar-fixed') === false) {
            return;
        }

        $('.page-sidebar').off('mouseenter').on('mouseenter', function () {
            var body = $('body');

            if ((body.hasClass('page-sidebar-closed') === false || body.hasClass('page-sidebar-fixed') === false) || $(this).hasClass('page-sidebar-hovering')) {
                return;
            }

            body.removeClass('page-sidebar-closed').addClass('page-sidebar-hover-on');

            if (body.hasClass("page-sidebar-reversed")) {
                $(this).width(sidebarWidth);
            } else {
                $(this).addClass('page-sidebar-hovering');
                $(this).animate({
                    width: sidebarWidth
                }, 400, '', function () {
                    $(this).removeClass('page-sidebar-hovering');
                });
            }
        });

        $('.page-sidebar').off('mouseleave').on('mouseleave', function () {
            var body = $('body');

            if ((body.hasClass('page-sidebar-hover-on') === false || body.hasClass('page-sidebar-fixed') === false) || $(this).hasClass('page-sidebar-hovering')) {
                return;
            }

            if (body.hasClass("page-sidebar-reversed")) {
                $('body').addClass('page-sidebar-closed').removeClass('page-sidebar-hover-on');
                $(this).width(sidebarCollapsedWidth);
            } else {
                $(this).addClass('page-sidebar-hovering');
                $(this).animate({
                    width: sidebarCollapsedWidth
                }, 400, '', function () {
                    $('body').addClass('page-sidebar-closed').removeClass('page-sidebar-hover-on');
                    $(this).removeClass('page-sidebar-hovering');
                });
            }
        });
    }

    // Handles sidebar toggler to close/hide the sidebar.
    var handleSidebarToggler = function () {
        var viewport = _getViewPort();
        if ($.cookie && $.cookie('sidebar_closed') === '1' && viewport.width >= 992) {
            $('body').addClass('page-sidebar-closed');
        }

        // handle sidebar show/hide
        $('.page-sidebar, .header').on('click', '.sidebar-toggler', function (e) {
            var body = $('body');
            var sidebar = $('.page-sidebar');

            if ((body.hasClass("page-sidebar-hover-on") && body.hasClass('page-sidebar-fixed')) || sidebar.hasClass('page-sidebar-hovering')) {
                body.removeClass('page-sidebar-hover-on');
                sidebar.css('width', '').hide().show();
                handleSidebarAndContentHeight(); //fix content & sidebar height
                if ($.cookie) {
                    $.cookie('sidebar_closed', '0');
                }
                e.stopPropagation();
                runResponsiveHandlers();
                return;
            }

            $(".sidebar-search", sidebar).removeClass("open");

            if (body.hasClass("page-sidebar-closed")) {
                body.removeClass("page-sidebar-closed");
                if (body.hasClass('page-sidebar-fixed')) {
                    sidebar.css('width', '');
                }
                if ($.cookie) {
                    $.cookie('sidebar_closed', '0');
                }
            } else {
                body.addClass("page-sidebar-closed");
                if ($.cookie) {
                    $.cookie('sidebar_closed', '1');
                }
            }
            handleSidebarAndContentHeight(); //fix content & sidebar height
            runResponsiveHandlers();
        });

        // handle the search bar close
        $('.page-sidebar').on('click', '.sidebar-search .remove', function (e) {
            e.preventDefault();
            $('.sidebar-search').removeClass("open");
        });

        // handle the search query submit on enter press
        $('.page-sidebar .sidebar-search').on('keypress', 'input.form-control', function (e) {
            if (e.which == 13) {
                $('.sidebar-search').submit();
                return false; //<---- Add this line
            }
        });

        // handle the search submit(for sidebar search and responsive mode of the header search)
        $('.sidebar-search .submit').on('click', function (e) {
            e.preventDefault();
            if ($('body').hasClass("page-sidebar-closed")) {
                if ($('.sidebar-search').hasClass('open') == false) {
                    if ($('.page-sidebar-fixed').size() === 1) {
                        $('.page-sidebar .sidebar-toggler').click(); //trigger sidebar toggle button
                    }
                    $('.sidebar-search').addClass("open");
                } else {
                    $('.sidebar-search').submit();
                }
            } else {
                $('.sidebar-search').submit();
            }
        });

        // header search box:

        // handle the search query submit on enter press
        $('.header .search-form').on('keypress', 'input.form-control', function (e) {
            if (e.which == 13) {
                $('.sidebar-search').submit();
                return false; //<---- Add this line
            }
        });

        //handle header search button click
        $('.header .search-form .submit').on('click', function (e) {
            e.preventDefault();
            $('.header .search-form').submit();
        });
    }

    // Handles the horizontal menu
    var handleHorizontalMenu = function () {
        //handle hor menu search form toggler click
        $('.header').on('click', '.hor-menu .hor-menu-search-form-toggler', function (e) {
            if ($(this).hasClass('off')) {
                $(this).removeClass('off');
                $('.header .hor-menu .search-form').hide();
            } else {
                $(this).addClass('off');
                $('.header .hor-menu .search-form').show();
            }
            e.preventDefault();
        });

        //handle tab click
        $('.header').on('click', '.hor-menu a[data-toggle="tab"]', function (e) {
            e.preventDefault();
            var nav = $(".hor-menu .nav");
            var active_link = nav.find('li.current');
            $('li.active', active_link).removeClass("active");
            $('.selected', active_link).remove();
            var new_link = $(this).parents('li').last();
            new_link.addClass("current");
            new_link.find("a:first").append('<span class="selected"></span>');
        });

        //handle hor menu search button click
        $('.header').on('click', '.hor-menu .search-form .btn', function (e) {
            $('.form-search').submit();
            e.preventDefault();
        });

        //handle hor menu search form on enter press
        $('.header').on('keypress', '.hor-menu .search-form input', function (e) {
            if (e.which == 13) {
                $('.form-search').submit();
                return false;
            }
        });
    }

    // Handles the go to top button at the footer
    var handleGoTop = function () {
        /* set variables locally for increased performance */
        jQuery('.footer').on('click', '.go-top', function (e) {
            App.scrollTo();
            e.preventDefault();
        });
    }

    // Handles portlet tools & actions
    var handlePortletTools = function () {
        jQuery('body').on('click', '.portlet > .portlet-title > .tools > a.remove', function (e) {
            e.preventDefault();
            jQuery(this).closest(".portlet").remove();
        });

        jQuery('body').on('click', '.portlet > .portlet-title > .tools > a.reload', function (e) {
            e.preventDefault();
            var el = jQuery(this).closest(".portlet").children(".portlet-body");
            var url = jQuery(this).attr("data-url");
            var error = $(this).attr("data-error-display");
            if (url) {
                App.blockUI({target: el, iconOnly: true});
                $.ajax({
                    type: "GET",
                    cache: false,
                    url: url,
                    dataType: "html",
                    success: function(res)
                    {
                        App.unblockUI(el);
                        el.html(res);
                    },
                    error: function(xhr, ajaxOptions, thrownError)
                    {
                        App.unblockUI(el);
                        var msg = 'Error on reloading the content. Please check your connection and try again.';
                        if (error == "toastr" && toastr) {
                            toastr.error(msg);
                        } else if (error == "notific8" && $.notific8) {
                            $.notific8('zindex', 11500);
                            $.notific8(msg, {theme: 'ruby', life: 3000});
                        } else {
                            alert(msg);
                        }
                    }
                });
            } else {
                // for demo purpose
                App.blockUI({target: el, iconOnly: true});
                window.setTimeout(function () {
                    App.unblockUI(el);
                }, 1000);
            }
        });

        // load ajax data on page init
        $('.portlet .portlet-title a.reload[data-load="true"]').click();

        jQuery('body').on('click', '.portlet > .portlet-title > .tools > .collapse, .portlet .portlet-title > .tools > .expand', function (e) {
            e.preventDefault();
            var el = jQuery(this).closest(".portlet").children(".portlet-body");
            if (jQuery(this).hasClass("collapse")) {
                jQuery(this).removeClass("collapse").addClass("expand");
                el.slideUp(200);
            } else {
                jQuery(this).removeClass("expand").addClass("collapse");
                el.slideDown(200);
            }
        });
    }

    // Handles custom checkboxes & radios using jQuery Uniform plugin
    var handleUniform = function () {
        if (!jQuery().uniform) {
            return;
        }
        var test = $("input[type=checkbox]:not(.toggle, .make-switch), input[type=radio]:not(.toggle, .star, .make-switch)");
        if (test.size() > 0) {
            test.each(function () {
                if ($(this).parents(".checker").size() == 0) {
                    $(this).show();
                    $(this).uniform();
                }
            });
        }
    }

    var handleBootstrapSwitch = function () {
        if (!jQuery().bootstrapSwitch) {
            return;
        }
        $('.make-switch').bootstrapSwitch();
    }

    // Handles Bootstrap Accordions.
    var handleAccordions = function () {
        jQuery('body').on('shown.bs.collapse', '.accordion.scrollable', function (e) {
            App.scrollTo($(e.target));
        });
    }

    // Handles Bootstrap Tabs.
    var handleTabs = function () {
        // fix content height on tab click
        $('body').on('shown.bs.tab', '.nav.nav-tabs', function () {
            handleSidebarAndContentHeight();
        });

        //activate tab if tab id provided in the URL
        if (location.hash) {
            var tabid = location.hash.substr(1);
            $('a[href="#' + tabid + '"]').parents('.tab-pane:hidden').each(function(){
                var tabid = $(this).attr("id");
                $('a[href="#' + tabid + '"]').click();
            });
            $('a[href="#' + tabid + '"]').click();
        }
    }

    // Handles Bootstrap Modals.
    var handleModals = function () {
        // fix stackable modal issue: when 2 or more modals opened, closing one of modal will remove .modal-open class. 
        $('body').on('hide.bs.modal', function () {
            if ($('.modal:visible').size() > 1 && $('html').hasClass('modal-open') == false) {
                $('html').addClass('modal-open');
            } else if ($('.modal:visible').size() <= 1) {
                $('html').removeClass('modal-open');
            }
        });

        $('body').on('show.bs.modal', '.modal', function () {
            if ($(this).hasClass("modal-scroll")) {
                $('body').addClass("modal-open-noscroll");
            }
        });

        $('body').on('hide.bs.modal', '.modal', function () {
            $('body').removeClass("modal-open-noscroll");
        });
    }

    // Handles Bootstrap Tooltips.
    var handleTooltips = function () {
        jQuery('.tooltips').tooltip();
    }

    // Handles Bootstrap Dropdowns
    var handleDropdowns = function () {
        /*
         Hold dropdown on click
         */
        $('body').on('click', '.dropdown-menu.hold-on-click', function (e) {
            e.stopPropagation();
        });
    }
    var handleDigists = function(){
        $('input.numbers').keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which <= 48 || e.which > 57)) {
                //display error message
                return false;
            }
        });
    }
    // Handle Hower Dropdowns
    var handleDropdownHover = function () {
        $('[data-hover="dropdown"]').dropdownHover();
    }

    var handleAlerts = function () {
        $('body').on('click', '[data-close="alert"]', function(e){
            $(this).parent('.alert').hide();
            e.preventDefault();
        });
    }

    // Handles Bootstrap Popovers

    // last popep popover
    var lastPopedPopover;

    var handlePopovers = function () {
        jQuery('.popovers').popover();

        // close last poped popover

        $(document).on('click.bs.popover.data-api', function (e) {
            if (lastPopedPopover) {
                lastPopedPopover.popover('hide');
            }
        });
    }

    // Handles scrollable contents using jQuery SlimScroll plugin.
    var handleScrollers = function () {
        $('.scroller').each(function () {
            var height;
            if ($(this).attr("data-height")) {
                height = $(this).attr("data-height");
            } else {
                height = $(this).css('height');
            }
            $(this).slimScroll({
                allowPageScroll: true, // allow page scroll when the element scroll is ended
                size: '7px',
                color: ($(this).attr("data-handle-color")  ? $(this).attr("data-handle-color") : '#bbb'),
                railColor: ($(this).attr("data-rail-color")  ? $(this).attr("data-rail-color") : '#eaeaea'),
                position: isRTL ? 'left' : 'right',
                height: height,
                alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                disableFadeOut: true
            });
        });
    }

    // Handles Image Preview using jQuery Fancybox plugin
    var handleFancybox = function () {
        if (!jQuery.fancybox) {
            return;
        }

        if (jQuery(".fancybox-button").size() > 0) {
            jQuery(".fancybox-button").fancybox({
                groupAttr: 'data-rel',
                prevEffect: 'none',
                nextEffect: 'none',
                closeBtn: true,
                helpers: {
                    title: {
                        type: 'inside'
                    }
                }
            });
        }
    }

    // Fix input placeholder issue for IE8 and IE9
    var handleFixInputPlaceholderForIE = function () {
        //fix html5 placeholder attribute for ie7 & ie8
        if (isIE8 || isIE9) { // ie8 & ie9
            // this is html5 placeholder fix for inputs, inputs with placeholder-no-fix class will be skipped(e.g: we need this for password fields)
            jQuery('input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)').each(function () {

                var input = jQuery(this);

                if (input.val() == '' && input.attr("placeholder") != '') {
                    input.addClass("placeholder").val(input.attr('placeholder'));
                }

                input.focus(function () {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });

                input.blur(function () {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }
    }

    // Handle full screen mode toggle
    var handleFullScreenMode = function() {
        // mozfullscreenerror event handler

        // toggle full screen
        function toggleFullScreen() {
            if (!document.fullscreenElement &&    // alternative standard method
                !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        }

        $('#trigger_fullscreen').click(function() {
            toggleFullScreen();
        });
    }

    // Handle Select2 Dropdowns
    var handleSelect2 = function() {
        if(arguments.length > 0) {
            if (jQuery().select2) {
                var context = arguments[0];
                $('select.select2me', arguments[0]).each(function () {
                    var este = $(this);
                    este.select2({
                        placeholder: "Seleccionar...",
                        allowClear: true,
                        formatNoMatches: function (term) {
                            return "No hay datos."
                        }
                    });
                    if(este.attr('autoopen') =='true')
                        este.select2('open');
                    //este.on('change',function(){
                    //    var este = $(this);
                    //    var form = este.closest('form');
                    //    if(form.size() != 0) {
                    //        var validator = este.closest('form').validate();
                    //        validator.element("#" + este.attr('id'));
                    //    }
                    //});
                    if (typeof(este.attr('parent')) != 'undefined') {
                        var parent = $(este.attr('parent'),context);
                        este.remoteChained({
                            parents: este.attr('parent'),
                            url: este.attr('path') + "?param=" + este.attr('param') + "&index=" + este.attr('index') + "&filter=" + este.attr('filter') + "&entity=" + este.attr('entity') + (typeof(este.attr('query')) != 'undefined' ? "&query=" + este.attr('query'):''),
                            loading: Mensajes.Loading,
                            bootstrap:true,
                            off: typeof(este.attr('off')) == 'undefined' || este.attr('off')== true,
                            context: context
                        });
                        if(este.attr('trigger')== "true")
                            parent.trigger('change');
                    }
                    if (typeof(este.attr('sameas')) != 'undefined') {
                        var parent = $(este.attr('sameas'));
                        parent.on('change',function(){
                            este.find('option').remove();

                            var option = $("<option />").val("").append("");
                            este.append(option);

                            este.trigger('change');
                            var values = parent.select2("val");
                            for(var i = 0; i < values.length;i++)
                            {
                                var text =parent.find('option[value="'+values[i]+'"]').text();
                                var option = $("<option />").val(values[i]).append(text);
                                este.append(option);
                            }
                        });
                        if(este.attr('trigger')== "true")
                            parent.trigger('change');
                    }
                });

            }
        }else{
            if (jQuery().select2) {
                $('select.select2me').each(function () {
                    var este = $(this);
                    este.select2({
                        placeholder: "Seleccionar...",
                        allowClear: true,
                        formatNoMatches: function (term) {
                            return "No hay datos."
                        }
                    });
                    if(este.attr('autoopen') =='true')
                        este.select2('open');
                    //este.on('change',function(){
                    //    var este = $(this);
                    //    var form = este.closest('form');
                    //    if(form.size() != 0) {
                    //        var validator = este.closest('form').validate();
                    //        validator.element("#" + este.attr('id'));
                    //    }
                    //});
                    if (typeof(este.attr('parent')) != 'undefined') {
                        var ctx = este.closest('form');
                        var parent = $(este.attr('parent'));
                        este.remoteChained({
                            parents: este.attr('parent'),
                            bootstrap:true,
                            off: typeof(este.attr('off')) == 'undefined' || este.attr('off')== true,
                            url: este.attr('path') + "?param=" + este.attr('param') + "&index=" + este.attr('index') + "&filter=" + este.attr('filter') + "&entity=" + este.attr('entity') + (typeof(este.attr('query')) != 'undefined' ? "&query=" + este.attr('query'):''),
                            loading: Mensajes.Loading
                        });
                        if(este.attr('trigger')== "true")
                            parent.trigger('change');
                    }
                    if (typeof(este.attr('sameas')) != 'undefined') {
                        var parent = $(este.attr('sameas'));
                        parent.on('change',function(){
                            este.find('option').remove();

                            var option = $("<option />").val("").append("");
                            este.append(option);

                            este.trigger('change');
                            var values = parent.select2("val");
                            for(var i = 0; i < values.length;i++)
                            {
                                var text =parent.find('option[value="'+values[i]+'"]').text();
                                var option = $("<option />").val(values[i]).append(text);
                                este.append(option);
                            }
                        });
                        if(este.attr('trigger')== "true")
                            parent.trigger('change');
                    }
                });

            }
        }

    }

    // Handle Theme Settings
    var handleTheme = function () {

        var panel = $('.theme-panel');

        if ($('body').hasClass('page-boxed') == false) {
            $('.layout-option', panel).val("fluid");
        }

        $('.sidebar-option', panel).val("default");
        $('.header-option', panel).val("fixed");
        $('.footer-option', panel).val("default");
        if ( $('.sidebar-pos-option').attr("disabled") === false) {
            $('.sidebar-pos-option', panel).val(App.isRTL() ? 'right' : 'left');
        }

        //handle theme layout
        var resetLayout = function () {
            $("body").
                removeClass("page-boxed").
                removeClass("page-footer-fixed").
                removeClass("page-sidebar-fixed").
                removeClass("page-header-fixed").
                removeClass("page-sidebar-reversed");

            $('.header > .header-inner').removeClass("container");

            if ($('.page-container').parent(".container").size() === 1) {
                $('.page-container').insertAfter('body > .clearfix');
            }

            if ($('.footer > .container').size() === 1) {
                $('.footer').html($('.footer > .container').html());
            } else if ($('.footer').parent(".container").size() === 1) {
                $('.footer').insertAfter('.page-container');
            }

            $('body > .container').remove();
        }

        var lastSelectedLayout = '';

        var setLayout = function () {

            var layoutOption = $('.layout-option', panel).val();
            var sidebarOption = $('.sidebar-option', panel).val();
            var headerOption = $('.header-option', panel).val();
            var footerOption = $('.footer-option', panel).val();
            var sidebarPosOption = $('.sidebar-pos-option', panel).val();

            if (sidebarOption == "fixed" && headerOption == "default") {
                alert('Default Header with Fixed Sidebar option is not supported. Proceed with Fixed Header with Fixed Sidebar.');
                $('.header-option', panel).val("fixed");
                $('.sidebar-option', panel).val("fixed");
                sidebarOption = 'fixed';
                headerOption = 'fixed';
            }

            resetLayout(); // reset layout to default state

            if (layoutOption === "boxed") {
                $("body").addClass("page-boxed");

                // set header
                $('.header > .header-inner').addClass("container");
                var cont = $('body > .clearfix').after('<div class="container"></div>');

                // set content
                $('.page-container').appendTo('body > .container');

                // set footer
                if (footerOption === 'fixed') {
                    $('.footer').html('<div class="container">' + $('.footer').html() + '</div>');
                } else {
                    $('.footer').appendTo('body > .container');
                }
            }

            if (lastSelectedLayout != layoutOption) {
                //layout changed, run responsive handler:
                runResponsiveHandlers();
            }
            lastSelectedLayout = layoutOption;

            //header
            if (headerOption === 'fixed') {
                $("body").addClass("page-header-fixed");
                $(".header").removeClass("navbar-static-top").addClass("navbar-fixed-top");
            } else {
                $("body").removeClass("page-header-fixed");
                $(".header").removeClass("navbar-fixed-top").addClass("navbar-static-top");
            }

            //sidebar
            if ($('body').hasClass('page-full-width') === false) {
                if (sidebarOption === 'fixed') {
                    $("body").addClass("page-sidebar-fixed");
                } else {
                    $("body").removeClass("page-sidebar-fixed");
                }
            }

            //footer 
            if (footerOption === 'fixed') {
                $("body").addClass("page-footer-fixed");
            } else {
                $("body").removeClass("page-footer-fixed");
            }

            //sidebar position
            if (App.isRTL()) {
                if (sidebarPosOption === 'left') {
                    $("body").addClass("page-sidebar-reversed");
                    $('#frontend-link').tooltip('destroy').tooltip({placement: 'right'});
                } else {
                    $("body").removeClass("page-sidebar-reversed");
                    $('#frontend-link').tooltip('destroy').tooltip({placement: 'left'});
                }
            } else {
                if (sidebarPosOption === 'right') {
                    $("body").addClass("page-sidebar-reversed");
                    $('#frontend-link').tooltip('destroy').tooltip({placement: 'left'});
                } else {
                    $("body").removeClass("page-sidebar-reversed");
                    $('#frontend-link').tooltip('destroy').tooltip({placement: 'right'});
                }
            }

            handleSidebarAndContentHeight(); // fix content height            
            handleFixedSidebar(); // reinitialize fixed sidebar
            handleFixedSidebarHoverable(); // reinitialize fixed sidebar hover effect
        }

        // handle theme colors
        var setColor = function (color) {
            var color_ = (App.isRTL() ? color + '-rtl' : color);
            $('#style_color').attr("href", "assets/css/themes/" + color_ + ".css");
            if ($.cookie) {
                $.cookie('style_color', color);
            }
        }

        $('.toggler', panel).click(function () {
            $('.toggler').hide();
            $('.toggler-close').show();
            $('.theme-panel > .theme-options').show();
        });

        $('.toggler-close', panel).click(function () {
            $('.toggler').show();
            $('.toggler-close').hide();
            $('.theme-panel > .theme-options').hide();
        });

        $('.theme-colors > ul > li', panel).click(function () {
            var color = $(this).attr("data-style");
            setColor(color);
            $('ul > li', panel).removeClass("current");
            $(this).addClass("current");
        });

        $('.layout-option, .header-option, .sidebar-option, .footer-option, .sidebar-pos-option', panel).change(setLayout);

        if ($.cookie && $.cookie('style_color')) {
            setColor($.cookie('style_color'));
        }
    }

    //* END:CORE HANDLERS *//

    return {
        //main function to initiate the theme
        init: function () {
            //IMPORTANT!!!: Do not modify the core handlers call order.
            handleDigists();
            //core handlers
            handleInit(); // initialize core variables
            handleResponsiveOnResize(); // set and handle responsive    
            handleUniform(); // hanfle custom radio & checkboxes
            handleBootstrapSwitch(); // handle bootstrap switch plugin
            handleScrollers(); // handles slim scrolling contents 
            handleResponsiveOnInit(); // handler responsive elements on page load

            //layout handlers
            handleFixedSidebar(); // handles fixed sidebar menu
            handleFixedSidebarHoverable(); // handles fixed sidebar on hover effect 
            handleSidebarMenu(); // handles main menu
            handleHorizontalMenu(); // handles horizontal menu
            handleSidebarToggler(); // handles sidebar hide/show            
            handleFixInputPlaceholderForIE(); // fixes/enables html5 placeholder attribute for IE9, IE8
            handleGoTop(); //handles scroll to top functionality in the footer
            handleTheme(); // handles style customer tool

            //ui component handlers
            handleFancybox() // handle fancy box
            handleSelect2(); // handle custom Select2 dropdowns
            handlePortletTools(); // handles portlet action bar functionality(refresh, configure, toggle, remove)
            handleAlerts(); //handle closabled alerts
            handleDropdowns(); // handle dropdowns
            handleTabs(); // handle tabs
            handleTooltips(); // handle bootstrap tooltips
            handlePopovers(); // handles bootstrap popovers
            handleAccordions(); //handles accordions 
            handleModals(); // handle modals
            handleFullScreenMode(); // handles full screen
            handleAjaxLinks();
            handleTimePickers
            $('.page-content form').validate();
        },

        //main function to initiate core javascript after ajax complete
        initAjax: function () {

            $('.page-content form').validate();
            handleDigists();
            handleScrollers(); // handles slim scrolling contents
            if(arguments.length > 0)
                handleSelect2(arguments[0]);
            else
                handleSelect2(); // handle custom Select2 dropdowns
            handleDropdowns(); // handle dropdowns
            handleTooltips(); // handle bootstrap tooltips
            handlePopovers(); // handles bootstrap popovers
            handleAccordions(); //handles accordions 
            handleUniform(); // hanfle custom radio & checkboxes     
            handleBootstrapSwitch(); // handle bootstrap switch plugin
            handleDropdownHover() // handles dropdown hover
            if(arguments.length > 0)
                handleAjaxLinks(arguments[0]);
            else
                handleAjaxLinks();

            if(arguments.length > 0)
                handleTimePickers(arguments[0]);
            else
                handleTimePickers();

        },
        //public function to fix the sidebar and content height accordingly
        fixContentHeight: function () {
            handleSidebarAndContentHeight();
        },

        //public function to remember last opened popover that needs to be closed on click
        setLastPopedPopover: function (el) {
            lastPopedPopover = el;
        },

        //public function to add callback a function which will be called on window resize
        addResponsiveHandler: function (func) {
            responsiveHandlers.push(func);
        },

        // useful function to make equal height for contacts stand side by side
        setEqualHeight: function (els) {
            var tallestEl = 0;
            els = jQuery(els);
            els.each(function () {
                var currentHeight = $(this).height();
                if (currentHeight > tallestEl) {
                    tallestColumn = currentHeight;
                }
            });
            els.height(tallestEl);
        },

        // wrapper function to scroll(focus) to an element
        scrollTo: function (el, offeset) {
            var pos = (el && el.size() > 0) ? el.offset().top : 0;

            if (el) {
                if ($('body').hasClass('page-header-fixed')) {
                    pos = pos - $('.header').height();
                }
                pos = pos + (offeset ? offeset : -1 * el.height());
            }

            jQuery('html,body').animate({
                scrollTop: pos
            }, 'slow');
        },

        // function to scroll to the top
        scrollTop: function () {
            App.scrollTo();
        },
        defaultAjaxContent: function(){
            return $('.page-content-body');
        },
        loadJS: function(url){
            //$.getScript(url);
            if( $('script[src="'+url+'"]').size() != 0 )
                $('script[src="'+url+'"]').remove();
            var s = document.createElement('script');
            s.src = url;
            document.body.appendChild(s);
        }
        ,
        onceJS: function (url) {
            if( $('script[src="'+url+'"]').size() == 0 )
            {
                var s = document.createElement('script');
                s.src = url;
                document.body.appendChild(s);
                //$.getScript(url);
                //var script = $("<script src='"+url+"' />");
                //$(document).append(script);
            }
        },
        loadCSS: function(url){
            var s = document.createElement('link');
            s.href = url;
            s.rel = "stylesheet";
            s.type = "text/css";
            document.head.appendChild(s);
        }
        ,
        onceCSS: function (url) {
            if( $('link[href="'+url+'"]').size() == 0 )
            {
                var s = document.createElement('link');
                s.href = url;
                s.rel = "stylesheet";
                s.type = "text/css";
                document.head.appendChild(s);
            }
        },
        loadAjax: function(url,target,params){
            //App.scrollTop();

            var  pageContentBody = target;

            App.blockUI({'target':target});

            if ($(window).width() <= 991 && $('.page-sidebar').hasClass("in")) {
                $('.navbar-toggle').click();
            }

            $.ajax({
                type: "GET",
                cache: false,
                url: url,
                data: params,
                dataType: "html",
                success: function (res) {
                    App.unblockUI(target);
                    pageContentBody.html(res);
                    // initialize core stuff
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    pageContentBody.html('<h4>No se cargar el contenido.</h4>');
                        App.toast("Ha ocurrido un error de permisos, por seguridad sera redirigido a la pantalla de inicio",Mensajes.OpError,TOAST.ERROR);
                           window.location.href = "http://148.234.110.253/app.php/";
                      

                    App.unblockUI(target);
                    //App.stopPageLoading();
                },
                complete: function(){
                    App.unblockUI(target);
                    App.fixContentHeight();
                    App.initAjax(target);
                }
            });
        },
        toast: function(msg,title,customization){

            if(typeof(customization) == 'undefined')
                customization = {type:'success'};
            if(customization=='error') {
                customization = {};
                customization.type = 'error'
            }
            if(customization=='success') {
                customization = {};
                customization.type = 'success'
            }
            if(!(customization.type))
                customization.type="success";

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "3500",
                "extendedTimeOut": "1000",
                "showEasing": "linear",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            }
            if(title == null)
                title=" ";
            if(msg == null)
                msg=" ";

            toastr[customization.type](msg,title);

        },
        toastOK: function(){
            App.toast(null,Mensajes.OpOK);
        },
        toastError: function(){
            App.toast(null,Mensajes.OpError,TOAST.ERROR);
        },
        AlertBootBox: function(msg){
            bootbox.alert({
                size: 'small',
                message: msg,
                buttons: {
                    ok: {
                        label: "Aceptar",
                        className: "btn-success",
                        callback: function() {}
                    }
                }
            });
        },
        // wrapper function to  block element(indicate loading)
        blockUI: function (options) {
            var options = $.extend(true, {}, options);
            var html = '';
            if(typeof(options.boxed) == 'undefined')
                options.boxed = false;
            if(typeof(options.iconOnly) == 'undefined')
                options.iconOnly = true;
            if (options.iconOnly) {
                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '')+'"><img style="" src='+GLOBAL.loadingSpinner+' align=""></div>';
            } else if (options.textOnly) {
                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '')+'"><span>&nbsp;&nbsp;' + (options.message ? options.message : Mensajes.Loading) + '</span></div>';
            } else {
                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '')+'"><img style="" src='+GLOBAL.loadingSpinner+' align=""><span>&nbsp;&nbsp;' + (options.message ? options.message : Mensajes.Loading) + '</span></div>';
            }
            if(!(options.target))
                options.target='.page-content';
            if (options.target) { // element blocking
                var el = jQuery(options.target);
                if (el.height() <= ($(window).height())) {
                    options.cenrerY = true;
                }
                el.block({
                    message: html,
                    baseZ: options.zIndex ? options.zIndex : 1000,
                    centerY: options.cenrerY != undefined ? options.cenrerY : false,
                    css: {
                        top: '10%',
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: options.overlayColor ? options.overlayColor : '#000',
                        opacity: options.boxed ? 0.05 : 0.1,
                        cursor: 'wait'
                    }
                });
            } else { // page blocking
                $.blockUI({
                    message: html,
                    baseZ: options.zIndex ? options.zIndex : 1000,
                    css: {
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: options.overlayColor ? options.overlayColor : '#000',
                        opacity: options.boxed ? 0.05 : 0.1,
                        cursor: 'wait'
                    }
                });
            }
        },

        // wrapper function to  un-block element(finish loading)
        unblockUI: function (target) {
            if(typeof(target) == 'undefined')
                target='.page-content';
            if (target) {
                jQuery(target).unblock({
                    onUnblock: function () {
                        jQuery(target).css('position', '');
                        jQuery(target).css('zoom', '');
                    }
                });
            }
        },

        startPageLoading: function(message) {
            App.blockUI();
            //$('.page-loading').remove();
            //$('body').append('<div class="page-loading"><img src='+GLOBAL.loadingSpinner+'/>&nbsp;&nbsp;<span>' + Mensajes.Loading+ '</span></div>');
        },

        stopPageLoading: function() {
            App.unblockUI();
            //$('.page-loading').remove();
        },

        // initializes uniform elements
        initUniform: function (els) {
            if (els) {
                jQuery(els).each(function () {
                    if ($(this).parents(".checker").size() == 0) {
                        $(this).show();
                        $(this).uniform();
                    }
                });
            } else {
                handleUniform();
            }
        },

        //wrapper function to update/sync jquery uniform checkbox & radios
        updateUniform: function (els) {
            $.uniform.update(els); // update the uniform checkbox & radios UI after the actual input control state changed
        },

        //public function to initialize the fancybox plugin
        initFancybox: function () {
            handleFancybox();
        },

        //public helper function to get actual input value(used in IE9 and IE8 due to placeholder attribute not supported)
        getActualVal: function (el) {
            var el = jQuery(el);
            if (el.val() === el.attr("placeholder")) {
                return "";
            }
            return el.val();
        },

        //public function to get a paremeter by name from URL
        getURLParameter: function (paramName) {
            var searchString = window.location.search.substring(1),
                i, val, params = searchString.split("&");

            for (i = 0; i < params.length; i++) {
                val = params[i].split("=");
                if (val[0] == paramName) {
                    return unescape(val[1]);
                }
            }
            return null;
        },

        // check for device touch support
        isTouchDevice: function () {
            try {
                document.createEvent("TouchEvent");
                return true;
            } catch (e) {
                return false;
            }
        },

        getUniqueID: function(prefix) {
            return 'prefix_' + Math.floor(Math.random() * (new Date()).getTime());
        },

        alert: function(options) {

            options = $.extend(true, {
                container: "", // alerts parent container(by default placed after the page breadcrumbs)
                place: "append", // append or prepent in container 
                type: 'success',  // alert's type
                message: "",  // alert's message
                close: true, // make alert closable
                reset: true, // close all previouse alerts first
                focus: true, // auto scroll to the alert after shown
                closeInSeconds: 3, // auto close after defined seconds
                icon: "" // put icon before the message
            }, options);

            var id = App.getUniqueID("app_alert");

            var html = '<div id="'+id+'" class="app-alerts alert alert-'+options.type+' fade in">' + (options.close ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' : '' ) + (options.icon != "" ? '<i class="fa-lg fa fa-'+options.icon + '"></i>  ' : '') + options.message+'</div>'

            if (options.reset) {0
                $('.app-alerts').remove();
            }

            if (!options.container) {
                $('.page-breadcrumb').after(html);
            } else {
                if (options.place == "append") {
                    $(options.container).append(html);
                } else {
                    $(options.container).prepend(html);
                }
            }

            if (options.focus) {
                App.scrollTo($('#' + id));
            }

            if (options.closeInSeconds > 0) {
                setTimeout(function(){
                    $('#' + id).remove();
                }, options.closeInSeconds * 1000);
            }
        },

        // check IE8 mode
        isIE8: function () {
            return isIE8;
        },

        // check IE9 mode
        isIE9: function () {
            return isIE9;
        },

        //check RTL mode
        isRTL: function () {
            return isRTL;
        },

        // get layout color code by color name
        getLayoutColorCode: function (name) {
            if (layoutColorCodes[name]) {
                return layoutColorCodes[name];
            } else {
                return '';
            }
        }

    };



}();
