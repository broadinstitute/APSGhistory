<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.viewrole.label')"/>
    </title>
    <meta name="section" content="roles"/>
    <meta name="pagename" content="viewrole"/>
    <meta name="help.url" content="<ww:property value="getText('help.role.view.details')"/>"/>
</head>
<body>
<h2>
    <ww:property value="getText('menu.viewrole.label')"/>
    &nbsp;&ndash;&nbsp;
    <ww:property value="name"/>
</h2>

<div class="page-content">

    <ol class="tabs">
        <li class="on">
            <span class="tab"><ww:property value="getText('menu.details.label')"/></span>
        </li>
        <li>
            <a id="view-role-principals"
               href='<ww:url action="viewusers" namespace="/console/secure/role" includeParams="none" ><ww:param name="directoryID" value="directoryID"/><ww:param name="roleName" value="name"/></ww:url>'>
                <ww:property value="getText('menu.principal.label')"/>
            </a>
        </li>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <form id="roleForm" method="post"
                  action="<ww:url namespace="/console/secure/role" action="update" method="updateGeneral" includeParams="none" />">
                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <input type="hidden" name="tab" value="1"/>
                    <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                    <input type="hidden" name="name" value="<ww:property value="name" />"/>


                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('role.name.label')"/>
                        <ww:param name="value">
                            <ww:property value="name"/>
                        </ww:param>
                    </ww:component>
                    
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('role.directory.label')"/>
                        <ww:param name="value">
                            <ww:property value="directory.name"/>
                            &nbsp;&mdash;&nbsp;
                            <ww:property value="directory.implementation.directoryType"/>
                        </ww:param>
                    </ww:component>

                    <ww:textfield name="description" size="50">
                        <ww:param name="label" value="getText('role.description.label')"/>
                    </ww:textfield>

                    <ww:checkbox name="active" fieldValue="true">
                        <ww:param name="label" value="getText('role.active.label')"/>
                    </ww:checkbox>
                </div>
                <div class="formFooter wizardFooter">

                    <div class="buttons">

                        <input type="submit" class="button"
                               value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/role" action="view" method="default" ><ww:param name="tab" value="1" /><ww:param name="directoryID" value="directoryID" /><ww:param name="name" value="name" /></ww:url>';"/>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
</body>
</html>