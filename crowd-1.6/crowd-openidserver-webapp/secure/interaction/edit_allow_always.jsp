<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('allow.edit.title')"/></title>
        <meta name="section" content="home" />
        <meta name="subsection" content="approvedsites" />

<script type="text/javascript">

    /***************************************************************
     *
     *  Javascript
     *
     ***************************************************************/

    // removes an entry from the table
    function removeEntry(deleteButton)
    {
        var table = document.getElementById('entryTable').getElementsByTagName("tbody")[0];
        var i = deleteButton.parentNode.parentNode.rowIndex;
        table.deleteRow(i);
    }


</script>

    </head>

    <body>

        <form method="post" action="<ww:url namespace="/secure/interaction" action="editallowalways" method="update" includeParams="none"/>" name="editallowalways">

            <div class="crowdForm">
                <div class="formTitle">
                    <h2><ww:property value="getText('allow.edit.title')"/></h2>
                </div>

                <div class="formBodyNoTop">

                    <p>

                        <ww:property value="getText('allow.allowedsites.text')"/>
                    </p>

                    <ww:include value="/include/generic_errors.jsp"/>

                    <ww:if test="siteApprovals.size > 0">

                        <table class="attributeTable" id="entryTable">
                            <tr class="attributePlainRow" height="30px">
                                <td class="attributePlainCell" width="400px">
                                    <b><ww:property value="getText('allow.siteurl.label')"/></b>
                                </td>

                                <td class="attributePlainCell">
                                    <b><ww:property value="getText('allow.profile.label')"/></b>
                                </td>

                                <td class="attributePlainCell" width="30px">

                                </td>
                            </tr>

                            <ww:iterator value="siteApprovals">
                                <tr class="attributeRow">
                                    <td class="attributeCellFirst" width="400px">
                                        <ww:property value="site.url"/>
                                        <input type="hidden" name="urls" value="<ww:property value="site.url"/>"/>
                                    </td>
                                    <td class="attributeCell">
                                        <select name="profileIDs" class="profile">
                                            <ww:iterator value="profiles">
                                                <option value="<ww:property value="id"/>" <ww:if test="id == profile.id">selected="selected"</ww:if> >
                                                    <ww:property value="name"/>
                                                </option>
                                            </ww:iterator>
                                        </select>
                                    </td>
                                    <td class="attributeCell">
                                        <img src="<ww:url value="/images/icons/delete.png"/>" alt="remove button" height="16" width="16" class="iconButton" onclick="removeEntry(this);" title="<ww:property value="getText('allow.edit.removesite.label')"/> "/>
                                    </td>
                                </tr>
                            </ww:iterator>

                        </table>

                    </ww:if>
                    <ww:else>

                        <p align="center">
                            <b><ww:property value="getText('allow.nosites.label')"/></b>
                        </p>
                    </ww:else>
                    
                </div>

                <div class="formFooter wizardFooter">
                    <ww:if test="siteApprovals.size > 0">
                        <div class="buttons">
                            <input type="submit" class="button" value="<ww:property value="getText('allow.edit.applychanges.label')"/>"/>
                            &nbsp;&nbsp;
                            <input type="button" class="button" value="<ww:property value="getText('allow.edit.cancel.label')"/>" onclick="location.href ='<ww:url namespace="/secure/interaction" action="editallowalways" method="default" includeParams="get"/>'"/>
                        </div>
                    </ww:if>
                    <ww:else>
                        &nbsp;
                    </ww:else>
                </div>

            </div>

        </form>

    </body>
</html>