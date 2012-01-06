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

    exports.ModalEditLink = new Class({
        Extends: modalOperations.ModalOperationLink,

        _doValidateForm: function(form)
        {
            return Grid_ValidateForm(form, false);
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
                                caption: localizer.getString('SaveAndEdit'),
                                click: function()
                                {
                                    self._processCommit(formContainer, errorContainer, function(newRow){
                                        (function() {
                                            var modalEditLink = newRow.find('a[modal-edit=true]');
                                            modalEditLink.click();
                                        }.bind(self)).delay(10)
                                    });
                                },
                                value: 'saveedit',
                                isDefault: false
                            }
                        ]
                });
        },

        _doUpdateGridAfterCommit: function(response, successCallback)
        {
            var newRow = this._updateRow(response);
            successCallback(newRow);
        },

        _updateRow: function(response)
        {
            var newRow = $($(response).find('row').text());
            var oldRow = this.container.closest('tr');
            var visibleNewRow = newRow.find('tr').first();

            visibleNewRow.removeClass('odd');
            visibleNewRow.removeClass('even');
            if (oldRow.hasClass('odd'))
                visibleNewRow.addClass('odd');
            if (oldRow.hasClass('even'))
                visibleNewRow.addClass('even');

            oldRow.nextAll("tr[pgui-details=true]").first().remove();
            newRow.insertAfter(oldRow);
            oldRow.remove();

            newRow.pgui_effects();
            newRow.pgui_unobtrusive();

            this.container.closest('table').sm_inline_grid_edit(
                {
                    row: newRow,
                    useBlockGUI: true
                });

            SetupModalEditors(newRow);
            ReloadImageColumns();

            RecalculateGridLineNumbers();

            return newRow;
        }
    });

    return exports;
});