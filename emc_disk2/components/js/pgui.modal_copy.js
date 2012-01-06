define([
    "require",
    PhpGen.Module.MooTools,
    PhpGen.Module.PG.Unobtrusive,
    PhpGen.Module.PG.DropDownButton,
    PhpGen.Module.PG.ModalOperations,
    PhpGen.Module.PG.Localizer
], function(require)
{
    var exports = {};

    var modalOperations = require(PhpGen.Module.PG.ModalOperations);
    var localizer = require(PhpGen.Module.PG.Localizer).localizer;
    
    exports.ModalCopyLink = new Class({
        Extends: modalOperations.ModalOperationLink,

        _doValidateForm: function(form)
        {   
            return Grid_ValidateForm(form, true);
        },

        _insertNewRow: function(response)
        {
            var newRow = $($(response).find('row').text());
            var rowToInsertAfter = $(this.container.attr('insert-after'));
            var nextRow = rowToInsertAfter.next('tr[pgui-details!=true]');

            newRow.insertAfter(rowToInsertAfter);

            var visibleNewRow = newRow.first();

            visibleNewRow.removeClass('odd');
            visibleNewRow.removeClass('even');
            if (nextRow.hasClass('even'))
                visibleNewRow.addClass('odd');
            if (nextRow.hasClass('odd'))
                visibleNewRow.addClass('even');

            newRow.pgui_effects();
            newRow.pgui_unobtrusive();

            this.container.closest('table').sm_inline_grid_edit(
                {
                    row: newRow,
                    useBlockGUI: true
                });
            SetupModalEditors(visibleNewRow);
            RecalculateGridLineNumbers();
        },

        _doUpdateGridAfterCommit: function(response, successCallback)
        {
            this._insertNewRow(response);
            successCallback();
        },

        _doOkCreateButton: function(container, formContainer, errorContainer)
        {
            var self = this;
            return PhpGen.createDropDownButton(container,
                {
                    defaultButtonCaption: localizer.getString('Save'),
                    buttons:
                        [
                            {
                                caption: localizer.getString('SaveAndBackToList'),
                                value: 'save',
                                click: function()
                                {
                                    self._processCommit(formContainer, errorContainer, function() { });
                                },
                                isDefault: true
                            },
                            {
                                caption: localizer.getString('SaveAndInsert'),
                                click: function()
                                {
                                    self._processCommit(formContainer, errorContainer, function() {
                                        (function() { this.container.click() }.bind(self)).delay(10)
                                    });
                                },
                                value: 'saveinsert',
                                isDefault: false
                            }
                        ]
                });
        }

    });

    return exports;
});