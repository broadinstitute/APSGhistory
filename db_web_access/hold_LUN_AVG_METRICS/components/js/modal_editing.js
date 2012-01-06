function SetupModalEditors(context)
{
    if (!context)
        context = $(document);
    
    context.find('a[modal-edit=true]').each(function(index, button)
    {
        var contentLink = $(button).attr("content-link");
        var isInsert =  $(button).attr("is-insert") == 'true';

        $(button).click(function(event){
            event.preventDefault();
            
            $.get(
                contentLink, { },
                function(data, status, xhr) {
                    var formContainer = $('<div>')
                    formContainer.attr('id', 'modal-form');

                    $('body').append(formContainer);
                    formContainer.append($(data));
                    formContainer.hide();

                    ProcessUnobtrusiveEditors(formContainer);
                    ProcessDependentAutocomplete(formContainer);

                    var errorContainer = $('<ul class="modal-editing-error-box">');
                    formContainer.append(errorContainer);
                    errorContainer.hide();
                    
                    formContainer.find('form').pgui_validate_form({
                        validate_errorClass: 'modal-edit-error',
                        validate_errorPlacement: function(error, element)
                        {
                            relatedElement = element;
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

                    $('#modal-form').dialog(
                    {
                        title: EscapeHTMLChars($(button).attr('dialog-title')),
                        width: formContainer.outerWidth() + 30,
                        modal: true,
                        buttons:
                        [
                            {
                                text: "Ok",
                                click: function()
                                {
                                    var dialog = $(this);
                                    var form = formContainer.find("form");

                                    form.ajaxSubmit(
                                    {
                                        dataType: 'xml',
                                        beforeSubmit : function(arr, $form, options)
                                        {
                                            if (!form.valid())
                                                return false;
                                            
                                            var legacyValidateForm = Grid_ValidateForm(form, isInsert);
                                            if (!legacyValidateForm.valid)
                                            {
                                                ShowLegacyError(errorContainer, legacyValidateForm.message);
                                                return false;
                                            }
                                            else
                                            {
                                                HideLegacyErrors(errorContainer);
                                            }
                                            $("body").css("cursor", "wait");
                                        },
                                        success: function(response, statusText, xhr)
                                        {
                                            if ($(response).find('type').text() == 'error')
                                            {
                                                VerticalGrid_ShowError(
                                                    VerticalGrid_Find(formContainer),
                                                    $(response).find('error_message')
                                                );
                                            }
                                            else
                                            {
                                                var newRow = $($(response).find('row').text());
                                                if (!isInsert)
                                                {
                                                    var oldRow = $(button).closest('tr');
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

                                                    $(button).closest('table').sm_inline_grid_edit(
                                                        {
                                                            row: newRow,
                                                            useBlockGUI: true
                                                        });
                                                    
                                                    SetupModalEditors(newRow);
                                                    ReloadImageColumns();
                                                    
                                                    RecalculateGridLineNumbers();
                                                }
                                                else
                                                {
                                                    var rowToInsertAfter = $($(button).attr('insert-after'));
                                                    var nextRow = rowToInsertAfter.next('tr');

                                                    var visibleNewRow = newRow.find('tr').first();
                                                    visibleNewRow.removeClass('odd');
                                                    visibleNewRow.removeClass('even');
                                                    if (nextRow.hasClass('even'))
                                                        visibleNewRow.addClass('odd');
                                                    if (nextRow.hasClass('odd'))
                                                        visibleNewRow.addClass('even');

                                                    newRow.insertAfter(rowToInsertAfter);

                                                    $(button).closest('table').sm_inline_grid_edit(
                                                        {
                                                            row: newRow,
                                                            useBlockGUI: true
                                                        });
                                                    SetupModalEditors(visibleNewRow);
                                                    RecalculateGridLineNumbers();
                                                }
                                                dialog.dialog("close");
                                            }
                                            $("body").css("cursor", "auto");
                                        }
                                    });
                                }
                            },
                            {
                                text: "Cancel",
                                click: function() { $(this).dialog("close"); }
                            }
                        ],
                        close: function(event, ui)
                        {
                            $("body").css("cursor", "auto");
                            formContainer.remove();
                        }
                    });
                });

        });
    });

    context.find('a[modal-delete=true]').each(function(index, button)
    {
         $(button).click(function(event)
         {
             event.preventDefault();

             ShowYesNoDialog('Confirmation', 'Delete record?',
                 function()
                 {
                     BlockInterface();
                     var url = $(button).attr('href');
                     var handlerName = $(button).attr('delete-handler-name');

                     $.get(
                         url + "&hname=" + handlerName,
                         { },
                         function(data)
                         {
                             UnblockInterface();
                             var response = $(data).find('response');
                             if (response.find('type').text() == 'error')
                             {
                                 ShowOkDialog('Error', response.find('error_message').text());
                             }
                             else
                             {
                                 var rowToDelete = $(button).closest('tr');
                                 rowToDelete.nextAll('tr[pgui-details]').first().remove();
                                 rowToDelete.remove();
                                 RecalculateGridLineNumbers();
                             }
                         },
                         'xml'
                     ).error(function() { UnblockInterface(); });
                 },
                 function() { });
         });
    });
}

function HideLegacyErrors(errorContainer)
{
    errorContainer.find('label[for=pglegacy]').closest('li').remove();
    if (errorContainer.find("li").length == 0)
        errorContainer.hide();
}

function ShowLegacyError(errorContainer, message)
{
    var error = $('<label class="modal-edit-error">' + message + '</label>');
    
    var oldError = errorContainer.find('label[for=pglegacy]');

    if ((oldError.length > 0 && oldError.text() != message) || (oldError.length == 0))
    {
        if (oldError.length > 0)
            oldError.closest("li").remove();
        error.attr('for', 'pglegacy');

        errorContainer.append(error);
        error.wrap("<li>");
        errorContainer.show();
    }
}

$(function(){ SetupModalEditors() });

