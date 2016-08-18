/*! Chained 1.0.0 - MIT license - Copyright 2010-2014 Mika Tuupola */
//!function(a){"use strict";a.fn.remoteChained=function(b){var c=a.extend({},a.fn.remoteChained.defaults,b);return c.loading&&(c.clear=!0),this.each(function(){function b(b){var c=a(":selected",d).val();a("option",d).remove();var e=[];if(a.isArray(b))e=a.isArray(b[0])?b:a.map(b,function(b){return a.map(b,function(a,b){return[[b,a]]})});else for(var f in b)b.hasOwnProperty(f)&&e.push([f,b[f]]);for(var g=0;g!==e.length;g++){var h=e[g][0],i=e[g][1];if("selected"!==h){var j=a("<option />").val(h).append(i);a(d).append(j)}else c=i}a(d).children().each(function(){a(this).val()===c+""&&a(this).attr("selected","selected")}),1===a("option",d).size()&&""===a(d).val()?a(d).prop("disabled",!0):a(d).prop("disabled",!1)}var d=this,e=!1;a(c.parents).each(function(){a(this).bind("change",function(){var f={};a(c.parents).each(function(){var b=a(this).attr(c.attribute),e=(a(this).is("select")?a(this).select2("val"):a(this).val());f[b]=e,c.depends&&a(c.depends).each(function(){if(d!==this){var b=a(this).attr(c.attribute),e=a(this).val();f[b]=e}})}),e&&a.isFunction(e.abort)&&(e.abort(),e=!1),c.clear&&(c.loading?b.call(d,{"":c.loading}):a("option",d).remove(),a(d).trigger("change")),e=a.getJSON(c.url,f,function(c){b.call(d,c),a(d).trigger("change")})}),c.bootstrap&&(b.call(d,c.bootstrap),c.bootstrap=null)})})},a.fn.remoteChainedTo=a.fn.remoteChained,a.fn.remoteChained.defaults={attribute:"name",depends:null,bootstrap:null,loading:null,clear:!1}}(window.jQuery||window.Zepto,window,document);

/*
 * Chained - jQuery / Zepto chained selects plugin
 *
 * Copyright (c) 2010-2014 Mika Tuupola
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 * http://www.appelsiini.net/projects/chained
 *
 * Version: 1.0.0
 *
 */
;(function($, window, document, undefined) {
    "use strict";
    $.fn.remoteChained = function(options) {
        var settings = $.extend({}, $.fn.remoteChained.defaults, options);
        /* Loading text always clears the select. */
        if (settings.loading) {
            settings.clear = true;
        }
        if(typeof(settings.off) == 'undefined')
            settings.off=true;
        return this.each(function() {
            /* Save this to self because this changes when scope changes. */
            var self = this;
            var request = false; /* Track xhr requests. */
            $(settings.parents).each(function() {
                var parent = null;
                if(settings.context)
                    parent = "#"+settings.context.attr('id')+" #"+ $(this).attr('id');
                var obj = " #"+$(this).attr('id');
                if (settings.context) {
                    obj = parent;
                }
                var changeF= function() {
                    /* Build data array from parents values. */
                    var data = {};
                    $(settings.parents).each(function() {
                        var parent = $(this);
                        if(settings.context)
                            parent = $("#"+settings.context.attr('id')+" #"+ $(this).attr('id'));

                        var id = parent.attr(settings.attribute);
                        var value = (parent.is("select") ?parent.select2("val") : parent.val());
                        data[id] = value;
                        /* Optionally also depend on values from these inputs. */
                        if (settings.depends) {
                            $(settings.depends).each(function() {
                                /* Do not include own value. */
                                if (self !== this) {
                                    var id = $(this).attr(settings.attribute);
                                    var value = $(this).val();
                                    data[id] = value;
                                }
                            });
                        }
                    });
                    /* If previous request running, abort it. */
                    /* TODO: Probably should use Sinon to test this. */
                    if (request && $.isFunction(request.abort)) {
                        request.abort();
                        request = false;
                    }
                    if (settings.clear) {
                        if (settings.loading) {
                            /* Clear the select and show loading text. */
                            build.call(self, {"" : settings.loading});
                        } else {
                            /* Clear the select. */
                            $("option", self).remove();
                        }
                        /* Force updating the children to clear too. */
                        $(self).trigger("change");
                    }
                    request = $.getJSON(settings.url, data, function(json) {
                        build.call(self, json);
                        /* Force updating the children. */
                        $(self).trigger("change");
                    });
                }
                if(settings.off)
                    $(document).off('change',obj);
                $(document).on('change',obj,changeF);
                /* If we have bootstrapped data given in options. */
                if (settings.bootstrap) {
                    build.call(self, settings.bootstrap);
                    settings.bootstrap = null;
                }
            });
            /* Build the select from given data. */
            function build(json) {
                /* If select already had something selected, preserve it. */
                var selected_key = $(":selected", self).val();
                /* Clear the select. */
                $("option", self).remove();
                var option_list = [];
                if ($.isArray(json)) {
                    if ($.isArray(json[0])) {
                        /* JSON is already an array of arrays. */
                        /* [["","--"],["series-1","1 series"],["series-3","3 series"]] */
                        option_list = json;
                    } else {
                        /* JSON is an array of objects. */
                        /* [{"":"--"},{"series-1":"1 series"},{"series-3":"3 series"}] */
                        json.unshift({"":""});
                        option_list = $.map(json, function(value) {
                            return $.map(value, function(value, index) {
                                return [[index, value]];
                            });
                        });
                    }
                } else {
                    /* JSON is an JavaScript object. Rebuild it as an array. */
                    /* {"":"--","series-1":"1 series","series-3":"3 series"} */
                    if(typeof(json[""]) != 'string')
                        option_list.push(["",""]);
                    for (var index in json) {
                        if (json.hasOwnProperty(index)) {
                            option_list.push([index, json[index]]);
                        }
                    }
                }
                /* Add new options from json. */
                //option_list.unshift(["",Mensajes.Seleccionar]);
                for (var i=0; i!==option_list.length; i++) {
                    var key = option_list[i][0];
                    var value = option_list[i][1];
                    /* Set the selected option from JSON. */
                    if ("selected" === key) {
                        selected_key = value;
                        continue;
                    }
                    var option = $("<option />").val(key).append(value);
                    $(self).append(option);
                }
                /* Loop option again to set selected. IE needed this... */
                $(self).children().each(function() {
                    if ($(this).val() === selected_key + "") {
                        $(this).attr("selected", "selected");
                    }
                });
                /* If we have only the default value disable select. */
                if (1 === $("option", self).size() && $(self).val() === "" && option_list[0][1] == settings.loading) {
                    $(self).prop("disabled", true);

                } else {
                    $(self).prop("disabled", false).select2("val","");
                }
            }
        });
    };
    /* Alias for those who like to use more English like syntax. */
    $.fn.remoteChainedTo = $.fn.remoteChained;
    /* Default settings for plugin. */
    $.fn.remoteChained.defaults = {
        attribute: "name",
        depends : null,
        bootstrap : null,
        loading : null,
        clear : false
    };
})(window.jQuery || window.Zepto, window, document);