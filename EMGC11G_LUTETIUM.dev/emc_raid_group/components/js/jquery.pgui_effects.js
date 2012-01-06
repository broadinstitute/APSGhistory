(function($){
    var methods =
    {
        init : function( options )
        {
            if (IsBrowserVersion({opera: 'none'}))
            {
                this.find(".default-fade-in").fadeTo(0, 0.5);

                this.find(".fade-out-on-hover")
                    .mouseenter(function()
                    {
                        $(this).fadeTo(0, 1);
                    }).mouseleave(function()
                    {
                        $(this).fadeTo(200, 0.5);
                    });
            }
        }
    };

    $.fn.pgui_effects = function( method )
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

$(function() { $(document).pgui_effects(); })
