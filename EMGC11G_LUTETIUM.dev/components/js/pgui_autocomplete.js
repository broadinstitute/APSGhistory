/* this allows us to pass in HTML tags to autocomplete. Without this they get escaped */
$[ "ui" ][ "autocomplete" ].prototype["_renderItem"] = function( ul, item) {
return $( "<li></li>" )
  .data( "item.autocomplete", item )
  .append( $( "<a></a>" ).html( item.label ) )
  .appendTo( ul );
};

function SetupSimpleAutocomplete(element)
{
    var itemToCopyId = $(element.attr('copy-id-to'));

    element.autocomplete(
    {
        // TODO doesn't work when loaded from /demos/#autocomplete|remote
        source: element.attr('data-url'),
        minLength: 0,
        select: function(event, ui)
        {
            if (ui.item)
            {
                itemToCopyId.val(ui.item.id);
            }
            else
            {
                itemToCopyId.val('');
            }
        },
        change: function(event, ui)
        {
            if (ui.item)
            {
                itemToCopyId.val(ui.item.id);
            }
            else
            {
                itemToCopyId.val('');
            }

        }/*,
        open: function(event, ui)
        {
             ( var widget = $(selectorId).autocomplete("widget");
            widget.css('left', widget.offset().left - 3);
            widget.css('top', widget.offset().top - 2)
            widget.css('width', '260px');
        } */

    });


    var button = element.closest("table").find("td.dropdown_button_column");

    button.attr('original-color', button.css('backgroundColor'));

    button.mouseover(function(){
            $(this).animate( {
                backgroundColor: '#aaa'
            }, 10);
        }
        ).mouseout(function(){
            $(this).animate( {
                backgroundColor: $(this).attr('original-color')
            }, 200);
        }
        ).click(function()
        {
            if (element.autocomplete("widget").is(":visible"))
            {
                element.autocomplete("close");
                return;
            }

            element.autocomplete("search");
            element.focus();
        });
}

function ProcessSimpleAutocomplete(context)
{
    $('input[pgui-autocomplete]', context).each(function(index, element)
    {
        SetupSimpleAutocomplete($(element));
    });
}

function SetupDependentAutocomplete(element)
{
    var behindInput = $(element.attr('copy-id-to'));
    var parentControl = $(element.attr('parent-autocomplete'))

    element.autocomplete(
        {
            minLength: 0,
            source: function( request, response ) {
                var parentValue = $(parentControl.attr('copy-id-to')).val();
                var requestUrl = element.attr('data-url');

                if (!(parentValue == undefined || parentValue == ''))
                    requestUrl = requestUrl + ('&term2=' + parentValue);

                if ( self.xhr ) {
                    self.xhr.abort();
                }
                self.xhr = $.ajax({
                    url: requestUrl,
                    data: request,
                    dataType: "json",
                    success: function( data, status, xhr ) {
                        if ( xhr === self.xhr ) {
                            response( data );
                        }
                        self.xhr = null;
                    },
                    error: function( xhr ) {
                        if ( xhr === self.xhr ) {
                            response( [] );
                        }
                        self.xhr = null;
                    }
                });
            },
            select:
                function(event, ui)
                {
                    if (ui.item)
                    {
                        behindInput.val(ui.item.id);
                    }
                    else
                    {
                        behindInput.val('');
                    }
                },
            change: function(event, ui)
                {
                    if (ui.item)
                    {
                        behindInput.val(ui.item.id);
                    }
                    else
                    {
                        behindInput.val('');
                    }
                }
        }
    );


    var button = element.closest('table.pgui-autocomplete-container').find('td.button');
    button.attr('original-color', button.css('backgroundColor'));

    button.mouseenter(
        function(){
            $(this).animate( {
                backgroundColor: '#aaa'
            }, 10);
        }
        ).mouseleave(
        function(){
            $(this).animate( {
                backgroundColor: $(this).attr('original-color')
            }, 200);
        }
        ).click(
        function(){
            if (element.autocomplete("widget").is(":visible"))
            {
                element.autocomplete("close");
                return;
            }

            element.autocomplete("search");
            element.focus();
        }
        );
}

$(function()
{
    ProcessDependentAutocomplete($(document));
});

function ProcessDependentAutocomplete(context)
{
    context.find('input.pgui-autocomplete').each(function(index, element)
    {
        SetupDependentAutocomplete($(element));
    });
}
