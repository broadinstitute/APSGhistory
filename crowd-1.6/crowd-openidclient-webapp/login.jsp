<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:text name="login.title"/></title>

        <meta name="section" content="profile"/>

<script type="text/javascript">

    /***************************************************************
     *
     *  Javascript to handle front-end attribute list manipulation.
     *
     ***************************************************************/

    var noAX = false; // stores if AX is used (NB: AX actually refers to SREG throughout the entire HTML file, SREG is a dumbed down but spec-ified version of AX)

    // event handler to check if return has been pressed on the attribute name field to add the attribute to the table
    function addAttribOnReturn(e)
    {
        var keynum;

        // get the key which was clicked
        if(window.event) // IE
        {
            keynum = e.keyCode;
        }
        else if(e.which) // Netscape/Firefox/Opera
        {
            keynum = e.which;
        }

        // if the key was a return then add the attribute
        if (keynum == 13)
        {
            addAttrib();

            // suppress automatic form submission
            return false;
        }
        else
        {
            return true;
        }
    }

    // adds an attribute to the attribute table
    function addAttrib()
    {
        var attribName = document.getElementById('newAttributeName').value;

        // don't add an attribute if there is no name specified
        if (attribName == null || attribName == '')
        {
            alert('You need to specify the name of the attribute to request.')
            return;
        }

        // don't add an attribute it it already exists
        if (doesAttribExist(attribName))
        {
            alert('Attribute "'+attribName+'" already exists on the list of attributes.');
            return
        }

        var attribReq  = document.getElementById('newAttributeRequiredTrue').checked;

        var table = document.getElementById('attributeTable').getElementsByTagName("tbody")[0];

        // check to see incase we have added an attribute after having zero attributes
        // to get rid of message notifying user that AX is disabled
        if (noAX)
        {
            table.deleteRow(1); // remove the second row (the row that contains AX disabled info)
            noAX = false;
        }

        // add new attribute to table

        var row = document.createElement('tr');
        row.className = 'attributeRow';

        var col1 = document.createElement('td');
        col1.className = 'attributeCellFirst';
        col1.innerHTML = attribName;

        var col2 = document.createElement('td');
        col2.className = 'attributeCell';
        col2.colSpan = '2';

        if (attribReq)
        {
            col2.innerHTML = '<input disabled="true" type="radio" name="' + attribName + 'Required" value="true" checked="true"><span class="attributeDisabled">Required</span> \
                          <input disabled="true" type="radio" name="' + attribName + 'Required" value="false"><span class="attributeDisabled">Optional</span> \
                          <input type="hidden" name="requiredAttribs" value="' + attribName + '"/>';
        }
        else
        {   col2.innerHTML = '<input disabled="true" type="radio" name="' + attribName + 'Required" value="true"><span class="attributeDisabled">Required</span> \
                          <input disabled="true" type="radio" name="' + attribName + 'Required" value="false" checked="true"><span class="attributeDisabled">Optional</span> \
                          <input type="hidden" name="optionalAttribs" value="' + attribName + '"/>';

        }

        var col3 = document.createElement('td');
        col3.className = 'attributeCell';
        col3.innerHTML = '<img src="<ww:url value="/images/icons/delete.png"/>" alt="remove button" height="16" width="16" class="iconButton" onclick="removeAttrib(this);" title="Remove attribute from list of requested attributes"/>';

        row.appendChild(col1);
        row.appendChild(col2);
        row.appendChild(col3);

        table.appendChild(row);

        // reset new attribute form fields
        document.getElementById('newAttributeName').value = '';
        document.getElementById('newAttributeRequiredTrue').checked = false;
        document.getElementById('newAttributeRequiredFalse').checked = true;
    }

    // returns true if an attribute name exists in the attribute table
    function doesAttribExist(attrib)
    {
        var table = document.getElementById('attributeTable').getElementsByTagName("tbody")[0];
        for (var i = 0; i < table.rows.length; i++)
        {
            if (table.rows[i].cells[0].innerHTML == attrib)
            {
                return true;
            }
        }
        return false;
    }

    // removes an attribute from the table
    function removeAttrib(deleteButton)
    {
        var table = document.getElementById('attributeTable').getElementsByTagName("tbody")[0];
        var i = deleteButton.parentNode.parentNode.rowIndex;
        table.deleteRow(i);
        showAXDisabledMessage(table);
    }

    // creates a row in the table to diplay a message when there are no attributes
    function showAXDisabledMessage(table)
    {
        // if there are no attribute rows left then notify user that AX is disabled
        if (table.rows.length == 1)
        {
            var row = document.createElement('tr');
            row.className = 'attributePlainRow';
            var col = document.createElement('td');
            col.className = 'attributePlainCell';
            col.colSpan = '4';
            col.innerHTML = "<i><ww:text name="login.no.attribs"/></i>";
            row.appendChild(col);
            table.appendChild(row);
            noAX = true;
        }
    }

    // removes all attributes from the table (and hence shows the message when there are no attributes)
    function removeAllAttribs()
    {
        var table = document.getElementById('attributeTable').getElementsByTagName("tbody")[0];
        while (table.rows.length > 1)
        {
            table.deleteRow(table.rows.length-1);
        }
        showAXDisabledMessage(table);
    }

</script>

    </head>

    <body>

    <form method="post" action="<ww:url namespace="/" action="login" method="login" includeParams="none" />" name="login">

        <div class="crowdForm">

            <h2><ww:text name="login.title"/></h2>
            <div class="formBodyNoTop">

                <ww:include value="/include/generic_errors.jsp"/>

                <ww:textfield name="openid_identifier" size="60" id="openid_identifier" onkeypress="">
                    <ww:param name="label" value="getText('openid.label')"/>
                </ww:textfield>
            </div>

            <h3><ww:text name="login.options.title"/></h3>
            <div class="formBodyNoTop">
                <ww:checkbox name="checkImmediate">
                    <ww:param name="label" value="getText('checkimmediate.label')"/>
                    <ww:param name="description" value="getText('checkimmediate.description')"/>
                </ww:checkbox>
                <ww:checkbox name="dummyMode">
                    <ww:param name="label" value="getText('dummymode.label')"/>
                    <ww:param name="description" value="getText('dummymode.description')"/>
                </ww:checkbox>
            </div>

            <h3><ww:text name="login.attrib.title"/></h3>
            <div class="formBodyNoTop">

                <table class="attributeTable" id="attributeTable">
                    <tr class="attributePlainRow" height="30px">
                        <td class="attributePlainCell" width="450px">
                            Attribute Name: &nbsp;&nbsp;<input type="text" name="newAttributeName" id="newAttributeName" size="30" onkeypress="return addAttribOnReturn(event);"/>
                        </td>

                        <td class="attributePlainCell">
                            <input type="radio" name="newAttribReq" id="newAttributeRequiredTrue" value="true">Required
                            <input type="radio" name="newAttribReq" id="newAttributeRequiredFalse" value="false" checked="true">Optional
                        </td>

                        <td class="attributePlainCell">
                            <img src="<ww:url value="/images/icons/add.png"/>" alt="add button" height="16" width="16" class="iconButton" onclick="addAttrib();" title="Add attribute to list of requested attributes"/>
                        </td>

                        <td class="attributePlainCell">
                            <img src="<ww:url value="/images/icons/cross.png"/>" alt="remove all button" height="16" width="16" class="iconButton" onclick="removeAllAttribs();" title="Remove all attributes"/>
                        </td>

                    </tr>

                    <ww:iterator value="requiredAttribs">
                        <tr class="attributeRow">
                            <td class="attributeCellFirst" width="450pxpx">
                                <ww:property/>
                            </td>
                            <td class="attributeCell" colspan="2">
                                <input disabled="true" type="radio" name="<ww:property/>Required" value="true" checked="true"><span class="attributeDisabled">Required</span>
                                <input disabled="true" type="radio" name="<ww:property/>Required" value="false"><span class="attributeDisabled">Optional</span>
                                <input type="hidden" name="requiredAttribs" value="<ww:property/>"/>
                            </td>
                            <td class="attributeCell">
                                <img src="<ww:url value="/images/icons/delete.png"/>" alt="remove button" height="16" width="16" class="iconButton" onclick="removeAttrib(this);" title="Remove attribute from list of requested attributes"/>
                            </td>
                        </tr>
                    </ww:iterator>

                    <ww:iterator value="optionalAttribs">
                        <tr class="attributeRow">
                            <td class="attributeCellFirst" width="300px">
                                <ww:property/>
                            </td>
                            <td class="attributeCell" colspan="2">
                                <input disabled="true" type="radio" name="<ww:property/>Required" value="true"><span class="attributeDisabled">Required</span>
                                <input disabled="true" type="radio" name="<ww:property/>Required" value="false" checked="true"><span class="attributeDisabled">Optional</span>
                                <input type="hidden" name="optionalAttribs" value="<ww:property/>"/>
                            </td>
                            <td class="attributeCell">
                                <img src="<ww:url value="/images/icons/delete.png"/>" alt="remove button" height="16" width="16" class="iconButton" onclick="removeAttrib(this);" title="Remove attribute from list of requested attributes"/>
                            </td>
                        </tr>
                    </ww:iterator>
                </table>

            </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('login.label')"/> &raquo;"/>
                    </div>
                </div>
            </div>

    </form>

    </body>
</html>