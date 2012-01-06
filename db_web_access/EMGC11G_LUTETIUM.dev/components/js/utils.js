function SetCookie(name, stages)
{
    var time = new Date();
    time.setTime(time.getTime() + 30 * 24 * 60 * 60 * 1000);
    document.cookie = name + '=' + stages + '; expires=' + time.toGMTString() +'; path=/';
}

function GetCookie(name)
{
    var prefix = name + '=';
    var indexBeg = document.cookie.indexOf(prefix);
    if (indexBeg == -1)
        return false;
    var indexEnd = document.cookie.indexOf(';', indexBeg + prefix.length);
    if (indexEnd == -1)
        indexEnd = document.cookie.length;
    return unescape(document.cookie.substring(indexBeg + prefix.length, indexEnd));
}    

$.fn.sm_hoverclass = function(hoverClass)
{
    var _this = this;

    function construct()
    {
        _this.each(function()
        {
            $(this).mouseover(function()
            {
                $(this).addClass(hoverClass);
            })
            .mouseout(function()
            {
                $(this).removeClass(hoverClass);
            });
        });
        return _this;
    }

    return construct();
}

Object.extend = function(destination, source)
{
    for (var property in source)
        destination[property] = source[property];
    return destination;
};

function IsBrowserVersion(browsers)
{
    var result = true;
    if ((browsers.msie != undefined) && ($.browser.msie))
        result = (browsers.msie != 'none') && (parseInt($.browser.version.slice(0, 1)) >= browsers.msie);
    if ((browsers.opera != undefined) && ($.browser.opera))
        result = (browsers.opera != 'none');
    if ((browsers.webkit != undefined) && ($.browser.webkit))
        result = (browsers.webkit != 'none');
    if ((browsers.mozilla != undefined) && ($.browser.mozilla))
        result = (browsers.mozilla != 'none');
    return result;
}

function InitValidationMethods()
{
    $.validator.addMethod('regexp', function (value, element, param)
    {
        var pattern = new RegExp(param);
        return value.match(pattern);
    }, 'Default regexp message');    
}

$(function() { InitValidationMethods(); })

$.fn.hasAttr = function(name)
{
    var attr = this.attr(name);
    return this.is("[" + name + "]") && (attr !== undefined) && (typeof attr !== 'undefined') && (attr !== false);
};

$.fn.attrDef = function(name, defaultValue)
{
    return this.hasAttr(name) ? this.attr(name) : defaultValue;  
};

function ProcessUnobtrusiveEditors(context)
{
    context.find('input[masked=true]').each(function()
    {
        if ($(this).attr('mask') != '')
            $(this).mask($(this).attr('mask'));
    });

    var timeEditInput = context.find('input[timeedit=true]');

    timeEditInput.wrap($('<span>').addClass('time-edit-wrapper'));
    timeEditInput.addClass("time-edit");
    timeEditInput.timeEntry(
    {
        spinnerImage: 'images/win7_spinners.png',
        spinnerSize: [17, 20, 0],
        spinnerIncDecOnly: true,
        showSeconds: true,
        show24Hours: true
    });

    var spinEditor = context.find("input[spinedit=true]");

    spinEditor.each(function(index, element)
    {
        $(element).spinbox(
        {
            max: $(element).attrDef("max", null),
            min: $(element).attrDef("min", null),
            step: $(element).attrDef("step", 1)
        });
        $(element).addClass("spin-edit");
    });

    ProcessSimpleAutocomplete(context);
}

$(function() { ProcessUnobtrusiveEditors($('body')); })

function ExtendedValidate()
{
    $('form[validate=true]').pgui_validate_form({
        validate_errorPlacement: function(error, element)
        {
            relatedElement = $(element.closest('tr'));

            error.css('position', 'absolute');
            error.offset(
            {
                top: relatedElement.offset().top,
                left: relatedElement.offset().left + relatedElement.outerWidth() + 10
            });

            error.hide();
            error.insertAfter(element);
            error.fadeIn(100);
        }
    });
}

function EscapeHTMLChars(text)
{
    return $('<div/>').text(text).html()
}

function PadNumber(number, length)
{
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}

function RecalculateGridLineNumbers()
{
    $('table.grid[show-line-numbers=true]').each(function(index, grid)
    {
        var startNumber = parseInt($(grid).attr('start-number'));
        var padCount = 0;
        var lineNumberCells = $(grid).find('tr[id!=grid_empty]').find('td.pgui-line-number');
        
        if ($(grid).attr('pad-line-number-count') == 'optimal')
        {
            var maxNumber = startNumber + $(grid).find('td.pgui-line-number').length;
            padCount = ('' + maxNumber).length;
        }
        else
        {
            padCount = parseInt($(grid).attr('pad-line-number-count')); 
        }
        lineNumberCells.each(function(index, cell){
            $(cell).html( PadNumber(index + startNumber, padCount) );
        });
    });
}

$(function() { RecalculateGridLineNumbers(); })

function BlockInterface()
{

    $.blockUI(
    {
        message: '<span class="wait_message">Please wait...</span>',
        overlayCSS:
        {
            backgroundColor: '#fff'
        },
        css:
        {
            border: 'none',
            padding: '15px',
            backgroundColor: '#aaa',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#000'
        }
    });
}

function UnblockInterface()
{
    $.unblockUI();

}
