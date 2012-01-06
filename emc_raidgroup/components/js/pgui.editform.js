define([PhpGen.Module.MooTools], function ()
{
    var exports = [];

    exports.EditForm = new Class({
        initialize: function(container)
        {
            this.container = container;
            this.submitButton = new PhpGen.DropDownButton(this.container.find('.submit-button'));

            this.resetButton = $('button.reset-button').button();
        }
    });

    exports.InsertForm = new Class({
        initialize: function(container)
        {
            this.container = container;
            this.submitButton = new PhpGen.DropDownButton(this.container.find('.submit-button'));

            this.resetButton = $('button.reset-button').button();
        }
    });

    return exports;
});