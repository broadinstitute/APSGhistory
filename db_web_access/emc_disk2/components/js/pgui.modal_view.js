define([PhpGen.Module.MooTools], function()
{
    var exports = [];

    exports.ModalViewLink = new Class({
        initialize: function(container)
        {
            this.container = container;
            this.modalViewLink = this.container.attr('content-link');
            this.dialogTitle  = this.container.attr('dialog-title');

            this.container.click(function(event)
            {
                event.preventDefault();
                this._invokeModalViewDialog();
            }.bind(this));
        },

        _invokeModalViewDialog: function()
        {
            $.get(this.modalViewLink,
                function(data)
                {
                    this._displayModalViewDialog($(data));
                }.bind(this));
        },

        _displayModalViewDialog: function(content)
        {
            var cardViewContainer = $('<div></div>');
            $('body').append(cardViewContainer);
            cardViewContainer.hide();
            cardViewContainer.append(content);

            cardViewContainer.dialog({
                title: this.dialogTitle,
                modal: false,
                width: cardViewContainer.outerWidth() + 30,
                buttons: {
                    'Close': function() {
                        $(this).dialog("close");
                    }
                }
            });

        }
    });

    return exports;
});