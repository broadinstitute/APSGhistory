var PhpGen = { };

PhpGen.ModuleList = function(list, order)
{
    order = (order === void 0) ? false : order;
    if (order)
        return _.map(_.flatten(list), function (item) { return "order!" + item; } );
    else
        return _.flatten(list);
};

PhpGen.Module = {
    Underscore : "underscore.min",
    MooTools: "components/js/mootools-core-1.4.1.js",
    Calendar: [
        "order!libs/calendar/js/jscal2.js",
        "order!libs/calendar/js/lang/en.js",
        "link!libs/calendar/css/jscal2.css",
        "link!libs/calendar/css/border-radius.css"
    ],

    TinyMCE: "libs/jquery/tiny_mce/jquery.tinymce.js",
    QTips: "libs/jquery/jquery.qtips.js",
    TimeEntry: [
        "libs/timeentry/jquery.timeentry.js",
        "libs/jquery/jquery.mousewheel.min.js",
        "link!libs/timeentry/jquery.timeentry.css"
        ],
    SpinBox: [
        "libs/spinbox/jquery.spinbox.js",
        "link!libs/spinbox/jquery.spinbox.css"
    ],
    LightBox: [
        "libs/jquery/jquery.lightbox.js",
        "link!libs/jquery/css/lightbox.css"
    ],
    Validate: "libs/jquery/jquery.validate.js",
    MaskEdit: "libs/jquery/jquery.maskedinput-1.2.2.js",
    HotKeys: "libs/jquery/jquery.hotkeys-0.7.9.min.js",
    Highlight: "libs/jquery/jquery.highlight-3.js",
    Color: "libs/jquery/jquery.color.js",
    FixedHeader: "libs/jquery/jquery.fixedtableheader-1-0-2.min.js",
    AjaxForm: "libs/jquery/jquery.form.js",
    UrlQuery: "libs/jquery/jquery.query.js",
    UIBlock: "libs/jquery/jquery.blockui.js",

    UI: {
        Dialog: PhpGen.ModuleList([
            "libs/jquery/development-bundle/ui/jquery.ui.core.js",
            "libs/jquery/development-bundle/ui/jquery.ui.position.js",
            "libs/jquery/development-bundle/ui/jquery.ui.widget.js",
            "libs/jquery/development-bundle/ui/jquery.ui.mouse.js",
            "libs/jquery/development-bundle/ui/jquery.ui.draggable.js",
            "libs/jquery/development-bundle/ui/jquery.ui.resizable.js",
            "libs/jquery/development-bundle/ui/jquery.ui.button.js",
            "libs/jquery/development-bundle/ui/jquery.ui.dialog.js"
        ]),

        AutoComplete: PhpGen.ModuleList([
            "libs/jquery/development-bundle/ui/jquery.ui.core.js",
            "libs/jquery/development-bundle/ui/jquery.ui.widget.js",
            "libs/jquery/development-bundle/ui/jquery.ui.position.js",
            "libs/jquery/development-bundle/ui/jquery.ui.autocomplete.js"
        ])

    },
    PG:
    {
        Editors: "pgui.editors",
        Utils: "pgui.utils",
        NavBar: "pgui.navbar_section",
        InlineEdit: "pgui.inline_grid_edit",
        TextHighlight: "pgui.text_highlight",
        Unobtrusive: "pgui.unobtrusive",
        DropDownButton: "pgui.dropdownbutton",
        ModalOperations: "pgui.modal_operations",
        Autocomplete: "pgui.autocomplete",
        Shortcuts: "pgui.shortcuts",
        Localizer: "pgui.localizer"
    }
};
