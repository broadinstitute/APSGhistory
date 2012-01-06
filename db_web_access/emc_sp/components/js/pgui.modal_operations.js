define([
    PhpGen.Module.MooTools,
    PhpGen.Module.PG.Unobtrusive,
    PhpGen.Module.PG.DropDownButton
], function()
{
    var exports = {};

    exports.ModalOperationLink = new Class({
        initialize: function(container)
        {
            this.container = container;
            this.contentLink = container.attr('content-link');
            this.container.click(function(event)
            {
                event.preventDefault();
                this._invokeModalDialog();
            }.bind(this));
                
        },

        _doOkCreateButton: function(container, formContainer, errorContainer)
        {
            return null;
        },

        _doValidateForm: function(form)
        {
            return null;
        },

        _doUpdateGridAfterCommit: function(response, successCallback)
        {
            return null;
        },

        _invokeModalDialog: function(){
            $.get(this.contentLink, {},
                function(data) {
                    this._showModalDialog($(data));
                }.bind(this));
        },

        _showModalDialog: function(content)
        {
            var self = this;
            var formContainer =
                $('<div></div>')
                .appendTo($('body'))
                .append(content)
                .hide();

            this._applyUnobtrusive(formContainer);
            var errorContainer = this._createErrorContainer(formContainer);
            this._applyFormValidator(formContainer, errorContainer);

            formContainer.dialog({
                title: this.container.attr('dialog-title'),
                width: formContainer.outerWidth() + 30,
                modal: true,
                beforeClose: function()
                {
                    self.editorsController.finalizeEditors();
                },
                open: function()
                {
                    self._createButtons($(this), formContainer, errorContainer);
                },
                close: function(event, ui)
                {
                    $("body").css("cursor", "auto");
                    formContainer.remove();
                }
            });
        },

        _createButtons: function(dialog, formContainer, errorContainer)
        {
            var uiDialogButtonPane = $('<div></div>')
                    .addClass('ui-dialog-buttonpane')
                    .addClass('ui-widget-content')
                    .addClass('ui-helper-clearfix');

            var uiButtonSet = $( "<div></div>" )
                    .addClass( "ui-dialog-buttonset" )
                    .appendTo( uiDialogButtonPane );

            var cancelButtonBlock = $('<div></div>').css('float', 'right').appendTo(uiButtonSet);

            var cancelButton =
                    $('<button type="button">Cancel</button>')
                            .click(function() { dialog.dialog('close'); })
                            .appendTo(cancelButtonBlock);
            cancelButton.button();

            var saveButtonBlock = $('<div></div>');
            saveButtonBlock.addClass('drop-down-list-margin-fix-wrapper');

            var saveButtonElement = this._doOkCreateButton(saveButtonBlock, formContainer, errorContainer);

            saveButtonBlock.appendTo(uiButtonSet);

            dialog.dialog('widget').append(uiDialogButtonPane);
            dialog.dialog('widget').css('overflow', 'visible');

            var saveButton = new PhpGen.DropDownButton(saveButtonElement);
        },

        _applyUnobtrusive: function(formContainer)
        {
            var self = this;
            require(PhpGen.ModuleList([PhpGen.Module.MooTools, PhpGen.Module.PG.Editors], true), function() {
                self.editorsController = PhpGen.InitializeEditorsController(PhpGen.DataOperation.Insert, formContainer);
            });

            ProcessUnobtrusiveEditors(formContainer);
            
            require([PhpGen.Module.PG.Autocomplete], function(autocomplete) {
                autocomplete.ProcessDependentAutocomplete(formContainer);
            });
        },

        _createErrorContainer: function(formContainer)
        {
            var errorContainer = $('<ul class="modal-editing-error-box">');
            formContainer.append(errorContainer);
            errorContainer.hide();
            return errorContainer;
        },

        _applyFormValidator: function(formContainer, errorContainer)
        {
            formContainer.find('form').pgui_validate_form({
                validate_errorClass: 'modal-edit-error',
                validate_errorPlacement: function(error, element)
                {
                    var oldError = $(errorContainer.find('label[for=' + error.attr('for') + ']'));

                    if ((oldError.length > 0 && oldError.text() != error.text()) || (oldError.length == 0))
                    {
                        if (oldError.length > 0)
                            oldError.closest("li").remove();
                        error.attr('for', element.attr('name'));

                        errorContainer.append(error);
                        error.wrap("<li>");
                        errorContainer.show();
                    }
                },
                validate_success: function (error)
                {
                    error.closest("li").remove();
                    if (errorContainer.find("li").length == 0)
                        errorContainer.hide();
                }
            });
        },

        _beforeFormSubmit: function(formContainer, errorContainer)
        {
            var form = formContainer.find("form");

            if (!form.valid())
                return false;

            var legacyValidateForm = this._doValidateForm(form);
            if (!legacyValidateForm.valid)
            {
                ShowLegacyError(errorContainer, legacyValidateForm.message);
                return false;
            }
            else
            {
                HideLegacyErrors(errorContainer);
            }
            return true;
        },

        _showError: function(formContainer, message)
        {
            VerticalGrid_ShowError(VerticalGrid_Find(formContainer), message);
        },

        _processCommit: function(formContainer, errorContainer, success)
        {
            var dialog = formContainer;
            var form = formContainer.find("form");

            require([PhpGen.Module.AjaxForm], function()
            {
                form.ajaxSubmit(
                {
                    dataType: 'xml',
                    beforeSubmit : function()
                    {
                        if (!this._beforeFormSubmit(formContainer, errorContainer))
                            return false;
                        $("body").css("cursor", "wait");
                    }.bind(this),
                    success: function(response)
                    {
                        if ($(response).find('type').text() == 'error')
                        {
                            this._showError(formContainer, $(response).find('error_message'))
                        }
                        else
                        {
                            this._doUpdateGridAfterCommit(response, success);
                            dialog.dialog("close");
                        }
                        $("body").css("cursor", "auto");
                    }.bind(this)
                });
            }.bind(this));
        }
    });

    return exports;
});