function expand(frameName, contentName, expandImageName, a)
{
    var nodeEl = document.getElementById(contentName);
    var expandImage = document.getElementById(expandImageName);

    if (nodeEl.className == 'hidden')
    {
        if (a && a.href != "javascript:;")
        {
            nodeEl.className = 'shown';
            nodeEl.innerHTML = 'Loading...';
            a.target = frameName;
            expandImage.src = 'images/collapse.gif';
        }
        else
        {
            nodeEl.className = 'shown';
            $('#' + contentName).slideDown();
            expandImage.src = 'images/collapse.gif';
        }

    }
    else
    {
        if (a)
            a.href = "javascript:;";
        $('#' + contentName).slideUp();
        nodeEl.className = 'hidden';
        expandImage.src = 'images/expand.gif';
    }
    return true;
}

function LoadDetail(node, content)
{
    contentControl = document.getElementById(node);
    contentControl.innerHTML = content.innerHTML;
    $('#' + node).hide();
    $('#' + node).slideDown();
    contentControl.className = 'shown';
}
