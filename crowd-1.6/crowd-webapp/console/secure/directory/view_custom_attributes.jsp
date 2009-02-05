<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="menu.viewdirectory.label">
            <ww:param id="0" value="directory.name"/>
        </ww:text>
    </title>

    <meta name="section" content="directories"/>
    <meta name="pagename" content="view"/>
    <meta name="help.url" content="<ww:property value="getText('help.directory.custom.attributes')"/>"/>

    <script type="text/javascript" language="javascript">

        function addAttribute()
        {
            var form = document.attributesForm;
            form.action = '<ww:url namespace="/console/secure/directory" action="updatecustomattributes" method="addAttribute" includeParams="none" />';
            form.submit();
        }

    </script>
    
</head>
<body>
<h2>
    <ww:text name="menu.viewdirectory.label">
        <ww:param id="0" value="directory.name"/>
    </ww:text>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li>
            <a id="custom-general"
               href="<ww:url namespace="/console/secure/directory" action="viewcustom" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                    name="menu.details.label"/></a>
        </li>

        <li class="on">
            <span class="tab"><ww:text name="menu.attributes.label"/></span>
        </li>

        <li>
            <a id="custom-permissions"
               href="<ww:url namespace="/console/secure/directory" action="updatecustompermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                    name="menu.permissions.label"/></a>
        </li>

    </ol>


    <div class="tabContent static" id="tab1">

        <div class="crowdForm">
            <form name="attributesForm" method="post"
                  action="<ww:url namespace="/console/secure/directory" action="updatecustomattributes" method="update" includeParams="none" />">
                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                    <table id="attributesTable">
                        <tr>
                            <th width="40%">
                                <ww:text name="attribute.label"/>
                            </th>
                            <th width="40%">
                                <ww:text name="values.label"/>
                            </th>
                            <th width="20%">
                                <ww:text name="browser.action.label"/>
                            </th>
                        </tr>

                        <ww:iterator value="directory.attributes" status="rowstatus">

                            <input type="hidden" name="attributes" value="<ww:property value="key" />"/>

                            <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                            <ww:else><tr class="even"></ww:else>
                            <td>
                                <ww:property value="key"/>
                            </td>
                            <td>
                                <ww:iterator value="value.values" status="valuestatus">
                                    <input type="text" name="<ww:property value="key" /><ww:property value="#valuestatus.count" />" value="<ww:property />"
                                           size="30"/><br/>
                                </ww:iterator>
                            </td>
                            <td>
                                <a id="remove-attribute-<ww:property value="key"/>" href="<ww:url namespace="/console/secure/directory" action="updatecustomattributes" method="removeAttribute" includeParams="none" ><ww:param name="attribute" value="key" /><ww:param name="ID" value="ID" /></ww:url>"
                                   title="<ww:property value="getText('remove.label')"/>">
                                    <ww:property value="getText('remove.label')"/>
                                </a>
                            </td>
                            </tr>

                        </ww:iterator>
                    </table>
                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons" style="padding-top:5px;">

                        <ww:text name="attribute.label"/>
                        :&nbsp;<input type="text" name="attribute" size="15" value="<ww:property value="attribute" />"/>&nbsp;
                        <ww:text name="value.label"/>
                        :&nbsp;<input type="text" name="value" size="15" value="<ww:property value="value" />"/>&nbsp;
                        <input id="add-attribute" type="button" class="button" value="<ww:text name="add.label"/> &raquo;" onClick="addAttribute();"/>
                        <input type="submit" class="button" value="<ww:text name="update.label"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:text name="cancel.label"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="updatecustom" method="default" includeParams="none"><ww:param name="ID" value="ID"/></ww:url>';"/>
                    </div>
                </div>

            </form>

        </div>

    </div>

</div>
</body>
</html>