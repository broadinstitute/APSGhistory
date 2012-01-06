// Convert to jquery plugin
function VerticalGrid_ShowError(grid, message)
{
    var messageContainer = grid.find('.error-message-container');
    messageContainer.html(message);
    messageContainer.slideDown(100);
}

function VerticalGrid_Find(context)
{
    return context.find('div[vertical-grid=true]');
}

function VerticalGrid_Prepare()
{
    
}