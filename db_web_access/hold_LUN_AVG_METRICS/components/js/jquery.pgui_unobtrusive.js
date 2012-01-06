
(function ($)
{
    var methods =
    {
        init: function(options)
        {
            function ProcessImageThumbnails(context)
            {
                $("a[rel=zoom]", context).lightbox();
            }

            function ProcessHeaderHints(context)
            {
                $('.hinted_header', context).each(function(i) {
                    if ($(this).children('div.box_hidden_header').html())
                        $(this).qtip({
                                container:  ('header_tip_' + i),
                                content:($(this).children('div.box_hidden_header').html()),
                                position: 'center',
                                tip_class: 'qtip-wrapper-header'
                            });
                });
            }

            function ProcessHints(context)
            {
                $('span.more_hint', context).each(function(i)
                {
                    $(this).qtip(
                        {
                            container: ('tip_' + i),
                            content: ($(this).children('div.box_hidden').html()),
                            position: 'center'
                        }
                    );
                });
            }
            
            function ProcessValidationForms(context)
            {
                ExtendedValidate();
            }

            function ProcessFixedHeader(context)
            {
                if (IsBrowserVersion({msie: 8, opera: 'none'}))
                {
                    if ($.browser.msie)
                    {
                        $('table.grid th#actions', context).width('1%');
                        $('table.grid th.row-selector', context).width('1%');
                    }

                    $('table[fixed-header=true]', context).fixedtableheader({
                       headerrowsize: $('table[fixed-header=true]', context).attr('header-row-size')
                    });
                }
            }

            this.each(function(index, element)
            {
                ProcessImageThumbnails(element);
                ProcessValidationForms(element);
                ProcessFixedHeader(element);
                ProcessHints(element);
                ProcessHeaderHints(element);
            });
        }
    }

    $.fn.pgui_unobtrusive = function( method )
    {
        if (methods[method])
        {
            return methods[method].apply(this,
                Array.prototype.slice.call(arguments, 1)
            );
        }
        else if (typeof method === 'object' || !method)
        {
            return methods.init.apply(this, arguments);
        }
        else
        {
            $.error('Method ' +  method + ' does not exist on jQuery.pgui_effects');
        }
    };
})(jQuery);

$(function()
{
    $(document).pgui_unobtrusive();
});