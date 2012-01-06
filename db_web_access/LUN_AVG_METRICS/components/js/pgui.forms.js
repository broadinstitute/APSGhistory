define(["require", "pgui.editform"], function(require)
{
    var EditForm = require("pgui.editform");

    $(function()
    {
        if ($('div.pgui-editform').length > 0)
            var editForm = new EditForm.EditForm($('div.pgui-editform'));

        if ($('div.pgui-insertform').length > 0)
            var insertForm = new EditForm.InsertForm($('div.pgui-insertform'));
    });

});