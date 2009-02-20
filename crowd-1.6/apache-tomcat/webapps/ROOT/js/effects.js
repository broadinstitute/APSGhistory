
// Provide hover and click effect to entire table rows.
// (removed click effect - it was annoying - mike 1/10/03)
// Usage:
// <table class="grid">
//   <tr href="somelink.jsp" onmouseover="rowHover(this)">
//   ...
var oFCKeditor;

function rowHover(row) {
	if (!row.href && row.getAttribute) row.href = row.getAttribute("href");
	if (!row.href) return;
	row.oldClassName = row.className;
	row.className = 'gridHover';
	row.onmouseout = function() {
		this.className = this.oldClassName;
	}
//	row.onclick = function() {
//		document.location.href = this.href;
//  }
}

function placeFocus() {
    // If the page has been loaded with an #anchor, don't place focus because it breaks the anchor
    // If the page contains a page-edit form, don't place focus because it pisses people off too frequently
    if (document.location.hash || document.getElementById("editpageform") || document.getElementById("createpageform"))
    {
        return;
    }

    // allow ability to customize which textfield the focus goes to (by specifying "?autofocus=<id of element>")
    var autoFocusElementId = "";
    var queryString = window.location.search.substring(1); // substring to remove the leading "?"
    var parameterPairs = queryString.split("&");
    for (var i = 0; i < parameterPairs.length; i++)
    {
        var key = parameterPairs[i].split("=")[0];
        var value = parameterPairs[i].split("=")[1];
        if (key == "autofocus" && (value != null && value.length >0))
        {
            autoFocusElementId = "'" + value + "'"; // necessary single quotes as element ids returned by element.id contain them
        }
    }

    var stopNow=false;
	for (var i=0; i < document.forms.length; i++) {
		var currSet=document.forms[i].elements;
		if (document.forms[i].name!='searchForm' && document.forms[i].name!='inlinecommentform') {
			for (var j = 0; j < currSet.length; j++)
            {
				if (
                        (currSet[j].type=='text' || currSet[j].type=='password' || currSet[j].type=='textarea')
                          && !currSet[j].disabled
                          && !(currSet[j].style.display == 'none')
                )
                {
                    try
                    {
                        if (autoFocusElementId != null && autoFocusElementId.length > 0)
                        {
                            if (currSet[j].id == autoFocusElementId)
                            {
                                currSet[j].focus();
                                stopNow = true;
                                break;
                            }
                        }
                        else
                        {
                            currSet[j].focus();
                            stopNow = true;
                            break;
                        }
                    }
                    catch (e)
                    {
                        // ignore
                        // setting focus to input elements inside hidden div's causes an exception on IE
                    }
                }
			}
		}
		if (stopNow)
			break;
	}
}

function checkAllCheckBoxes(field)
{
    for (i = 0; i < field.length; i++)
        field[i].checked = true ;
}

function clearAllCheckBoxes(field)
{
    for (i = 0; i < field.length; i++)
        field[i].checked = false ;
}

function openUserPickerWindow(formName, element)
{
    var vWinUsers = window.open('openuserpicker.action?key=$key&formName=' + formName + '&elementName=' + element + '&multiSelect=true&startIndex=0&usersPerPage=10', 'UserPicker2', 'status=yes,resizable=yes,top=100,left=200,width=580,height=550,scrollbars=yes');
    vWinUsers.opener = self;
    vWinUsers.focus();
}

function getCurrentFormContent(form)
{
    var newContent;
    if (tinyMCE != null && form.xhtml.value == 'true')
    {
      return tinyMCE.getContentWithoutMovingCursor();
    }
    if (form.markupTextarea)
    {
        return form.markupTextarea.value;
    }
}

var contentHasChanged = false;
function saveDraftOnPageChange(anchorElement)
{
    var gotoNewPage = function() {window.location = anchorElement.href};
    if (contentHasChanged)
        saveDraft(gotoNewPage);
    else
        gotoNewPage();
}

function toggleVisibility(elementId)
{
    var element = document.getElementById(elementId);
    if(element.style.display == 'none'){
        element.style.display = 'block';
    }
    else{
        element.style.display = 'none';
    }
}