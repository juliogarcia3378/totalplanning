$.jstree.defaults.contextmenu = {
    /**
     * a boolean indicating if the node should be selected when the context menu is invoked on it. Defaults to `true`.
     * @name $.jstree.defaults.contextmenu.select_node
     * @plugin contextmenu
     */
    select_node : true,
    /**
     * a boolean indicating if the menu should be shown aligned with the node. Defaults to `true`, otherwise the mouse coordinates are used.
     * @name $.jstree.defaults.contextmenu.show_at_node
     * @plugin contextmenu
     */
    show_at_node : true,
    /**
     * an object of actions, or a function that accepts a node and returns an object of actions available for that node.
     *
     * Each action consists of a key (a unique name) and a value which is an object with the following properties:
     *
     * * `separator_before` - a boolean indicating if there should be a separator before this item
     * * `separator_after` - a boolean indicating if there should be a separator after this item
     * * `_disabled` - a boolean indicating if this action should be disabled
     * * `label` - a string - the name of the action
     * * `action` - a function to be executed if this item is chosen
     *
     * @name $.jstree.defaults.contextmenu.items
     * @plugin contextmenu
     */
    items : function (o) { // Could be an object directly
        return {
            "rename" : {
                "separator_before"	: false,
                "separator_after"	: false,
                "_disabled"			: false, //(this.check("rename_node", data.reference, this.get_parent(data.reference), "")),
                "label"				: "Editar",
                "action"			: function (data) {
                    var inst = $.jstree.reference(data.reference),
                        obj = inst.get_node(data.reference);
                    inst.edit(obj);
                }
            },
            "remove" : {
                "separator_before"	: false,
                "icon"				: false,
                "separator_after"	: false,
                "_disabled"			: false, //(this.check("delete_node", data.reference, this.get_parent(data.reference), "")),
                "label"				: "Eliminar",
                "action"			: function (data) {
                    var inst = $.jstree.reference(data.reference),
                        obj = inst.get_node(data.reference);
                    if(inst.is_selected(obj)) {
                        inst.delete_node(inst.get_selected());
                    }
                    else {
                        inst.delete_node(obj);
                    }
                }
            }
        };
    }
};
