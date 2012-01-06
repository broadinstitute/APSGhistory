function SetupModalEditors(context)
{
    if (!context)
        context = $(document);
    
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

                     $.ajax({
                         url: url + "&hname=" + handlerName,
                         data: {},
                         success:
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
                         dataType: 'xml',
                         error: function() { UnblockInterface(); }
                     });
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

