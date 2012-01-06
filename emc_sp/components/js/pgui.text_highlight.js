define(PhpGen.ModuleList([PhpGen.Module.Highlight]), function()
{
    var exports = {};

    exports.HighlightTextInGrid = function (gridSelector, fieldName, text, opt, a_hint)
    {
        var hint_text = '';
        if (a_hint)
            hint_text = a_hint;

        $(gridSelector + " tr td.even[char=data][data-column-name='"+fieldName+"']").highlight(text, opt, {
            hint: hint_text
        });
        $(gridSelector + " tr td.odd[char=data][data-column-name='"+fieldName+"']").highlight(text, opt, {
            hint: hint_text
        });
    };

    return exports;
});