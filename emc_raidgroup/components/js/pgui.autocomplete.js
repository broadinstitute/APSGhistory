define([PhpGen.Module.Color, PhpGen.Module.PG.Editors], function()
{
    var exports = {};

    PhpGen.SetupSimpleAutocomplete = function (element)
    {
        if (element.length > 0)
        {
            require(PhpGen.ModuleList([PhpGen.Module.UI.AutoComplete], true),
            function()
            {

                var itemToCopyId = $(element.attr('copy-id-to'));
                var fieldName = element.attr('data-field-name');

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
                            PhpGen.autoCompleteGlobalNotifier.valueChanged(fieldName);
                        }
                        else
                        {
                            itemToCopyId.val('');
                            PhpGen.autoCompleteGlobalNotifier.valueChanged(fieldName);
                        }

                    }
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
            });
        }
    }

    exports.ProcessSimpleAutocomplete = function (context)
    {
        $('input[pgui-autocomplete]', context).each(function(index, element)
        {
            PhpGen.SetupSimpleAutocomplete($(element));
        });
    };

    function SetupDependentAutocomplete(element)
    {

        if (element.length > 0)
        {
            require(PhpGen.ModuleList([PhpGen.Module.UI.AutoComplete], true),
            function()
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
            });
        }
    }

    exports.ProcessDependentAutocomplete = function (context)
    {
        context.find('input.pgui-autocomplete').each(function(index, element)
        {
            SetupDependentAutocomplete($(element));
        });
    }

    $(function()
    {
        exports.ProcessDependentAutocomplete($(document));
    });


    return exports;
});