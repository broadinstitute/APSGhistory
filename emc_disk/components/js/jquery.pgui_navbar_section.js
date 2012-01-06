;
$.fn.pgui_navbar_section = function(opts)
{
    var _this = this;

    // original elements
    var headerSelector = '> h3 > :first-child';
    var originalContainer = $(this);
    var headerSpan = originalContainer.find(headerSelector);

    // options
    var defaults =
        {
            saveToCookies: false,
            cookiesBaseId: 'sqlmaestro_phpgen_navbar_sections'
        };
    var options = $.extend(defaults, opts);

    function toogleContentCollapsed(originalContainer, animation)
    {
        var sectionContent = originalContainer.children('ul');
        var headerSpan = originalContainer.find(headerSelector);
        var hideIcon = headerSpan.children('.section_hide_button');
        hideIcon.toggleClass('section_hide_button_collapsed');
        hideIcon.toggleClass('section_hide_button_expanded');

        if (animation)
            sectionContent.slideToggle('fast');
        else
            sectionContent.hide();

        saveToCookie(originalContainer, hideIcon.hasClass('section_hide_button_collapsed'));
    }

    function saveToCookie(originalContainer, collapsed)
    {
        var baseId = originalContainer.attr('id');
        SetCookie(options.cookiesBaseId + '_' + baseId, collapsed);
    }

    function headerClickHandler()
    {
        toogleContentCollapsed($(this).parent().parent(), true);
    }

    function restoreFromCookie(originalContainer)
    {        
        originalContainer.each(function(index, element)
        {
            var baseId = $(element).attr('id');
            if (GetCookie(options.cookiesBaseId + '_' + baseId) == 'true')
                toogleContentCollapsed($(element), false);
        });   
    }

    function construct()
    {
        headerSpan.prepend('<div class="section_hide_button section_hide_button_expanded"></div>');
        headerSpan.addClass('collapsible_navbar_section_header');
        headerSpan.click(headerClickHandler);

        restoreFromCookie(originalContainer);

        return _this;
    }

    return construct();
}

sideBarHidden = GetCookie('sideBarHidden') == 'true';

function ApplySideBarPosition()
{
    if (sideBarHidden)
        $('#right_side_bar').hide();
}

function ToogleSideBar()
{
    if (sideBarHidden)
        $('#right_side_bar').show('normal');
    else
        $('#right_side_bar').hide('normal');
    sideBarHidden = !sideBarHidden;
    SetCookie('sideBarHidden', sideBarHidden ? 'true' : 'false');
}
