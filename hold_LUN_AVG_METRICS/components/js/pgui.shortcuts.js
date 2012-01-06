define([PhpGen.Module.HotKeys], function()
{
    var exports = {};
    
    var inputControlFocused = false;

    $(function()
    {
        $('input').blur(function() {
            inputControlFocused = false;
        });
        $('input').focus(function() {
            inputControlFocused = true;
        });
    });

    exports.InitializeShortCuts = function(item)
    {
        var shortCut = item.attr('pgui-shortcut');

        $(document).bind('keydown', shortCut, function() {
            if (!inputControlFocused) {
                if (item.is('a'))
                    window.location.href = item.attr('href');
            }
        });
    };

    return exports;

});