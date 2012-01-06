function CreateListByArray(valuesList)
{
    result = '';
    for(var i = 0; i < valuesList.length; i++)
        result = result + valuesList[i] + '<br/>'
    return result;
}

// <Shortcuts>

inputControlFocuced = false;
        
$(document).ready(function()
{    
    $('input').blur(function() {
        inputControlFocuced = false;
    });
    $('input').focus(function() {
        inputControlFocuced = true;
    });
});
            
function navigate_to(link)
{
    window.location.href = link;
}
    
function BindPageDecrementShortCut(prevPageLink)
{
    $(document).ready(function()
    {
        $(document).bind('keydown', 'Ctrl+left', function()
        {
            if (!inputControlFocuced)
                navigate_to(prevPageLink);
        });
    });
}
    
function BindPageIncrementShortCut(nextPageLink)
{
    $(document).ready(function()
    {
        $(document).bind('keydown', 'Ctrl+right', function()
        {
            if (!inputControlFocuced)
                navigate_to(nextPageLink);
        });
    });
}

// </Shortcuts>

function EnableHighlightRowAtHover(gridSelector)
{
    $(document).ready(function()
    {
        $(".grid tr.even").mouseover(function()
        {
            $(this).addClass("highlited");
        });
        $(".grid tr.odd").mouseover(function()
        {
            $(this).addClass("highlited");
        });
        $(".grid tr.odd").mouseout(function()
        {
            $(this).removeClass("highlited");
        });
        $(".grid tr.even").mouseout(function()
        {
            $(this).removeClass("highlited");
        });
    });
}

var highlightFunctions = new Array();
    
function HighlightTextInGrid(gridSelector, fieldName, text, opt, a_hint)
{
    var hint_text = '';
    if (a_hint)
        hint_text = a_hint;
        
    // highlightFunctions.push(function ()
    // {
    $(gridSelector + " tr td.even[char=data][data-column-name='"+fieldName+"']").highlight(text, opt, {
        hint: hint_text
    });
    $(gridSelector + " tr td.odd[char=data][data-column-name='"+fieldName+"']").highlight(text, opt, {
        hint: hint_text
    });
// });
}
    
function ShowHighligthAllSearches()
{
    for(i = 0; i < highlightFunctions.length - 1; i++)
        highlightFunctions[i]();
}
    
function HideHighligthAllSearches()
{
    $('.grid td').removeHighlight();
}
    
function ToggleHighligthAllSearches(highlightAllLink)
{
    if (highlightAllLink.hasClass('pressed'))
    {
        HideHighligthAllSearches();
        highlightAllLink.removeClass('pressed');
    }
    else
    {
        ShowHighligthAllSearches();
        highlightAllLink.addClass('pressed');
    }
}

$(function()
{
    $('.page_list').pgui_navbar_section({collapsed: true});
});

function ApplyPageSize(container, link) {

    var value = container.find('input:checked').val();
    if (value == 'custom')
        value = container.find('.pgui-custom-page-size').val();
    window.location = jQuery.query.set("recperpage", value);

}

function GetPageCountForPageSize(pageSize, rowCount) {
    if (pageSize > 0)
        return Math.floor(rowCount / pageSize) +
            ((Math.floor(rowCount / pageSize) == (rowCount / pageSize)) ? 0 : 1);
    else 
        return 1;
}

function ShowOkDialog(title, text) 
{
    var dialogContent = $('<div>');
    dialogContent.css('display', 'none');
    dialogContent.addClass('pgui-ok-dialog-content');
    dialogContent.attr('title', title);

    var dialogText = $('<p>');
    dialogText.append('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>');
    dialogText.append(text);

    dialogContent.append(dialogText);

    $('body').append(dialogContent);

    dialogContent.dialog(
        {
            modal: true,
            buttons:
            {
                OK: function () {
                    $(this).dialog('close');
                }
            }
        }
    );
}

function ShowYesNoDialog(title, text, yesAction, noAction) 
{
    var dialogContent = $('<div>');
    dialogContent.css('display', 'none');
    dialogContent.addClass('pgui-ok-dialog-content');
    dialogContent.attr('title', title);

    var dialogText = $('<p>');
    dialogText.append(text);

    dialogContent.append(dialogText);

    $('body').append(dialogContent);

    dialogContent.dialog(
        {
            modal: true,
            buttons:
            {
                Yes: function () {
                    $(this).dialog('close');
                    yesAction();
                },
                No: function () {
                    $(this).dialog('close');
                    noAction();
                }
            }
        }
    );
}

function ReloadImageColumns()
{
    $('img[data-image-column]').each(function(index, image) {
        $(image).attr("src", $(image).attr('src') + '&' + (new Date()).getTime());
    });
}

function WriteWYSIWYGValuesToTheirTextAreas()
{
    var editor = $('.html_wysiwyg');
    editor.each(function(index, element)
    {
        element.value = $(element).val();
    });

}