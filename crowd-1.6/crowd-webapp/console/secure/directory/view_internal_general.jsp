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
    <meta name="help.url" content="<ww:text name="help.directory.internal.details"/>"/>
</head>
<body>
<h2>
    <ww:text name="menu.viewdirectory.label">
        <ww:param id="0" value="directory.name"/>
    </ww:text>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li class="on">
            <span class="tab"><ww:text name="menu.details.label"/></span>
        </li>

        <li>
            <a id="internal-configuration" href="<ww:url namespace="/console/secure/directory" action="updateinternalconfiguration" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.configuration.label"/></a>
        </li>

        <li>
            <a id="internal-permissions" href="<ww:url namespace="/console/secure/directory" action="updateinternalpermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.permissions.label"/></a>
        </li>

    </ol>

    <div class="tabContent static">

        <div class="crowdForm">

            <form name="updateGeneral" method="post"
                  action="<ww:url namespace="/console/secure/directory" action="updateinternal" includeParams="none" />">

                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                    <ww:textfield name="name" size="50">
                        <ww:param name="label" value="getText('directoryinternal.name.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.name.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:textfield name="directoryDescription" size="50">
                        <ww:param name="label" value="getText('directoryinternal.description.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.description.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('directory.type.label')"/>
                        <ww:param name="value">
                            <ww:property value="directory.implementation.directoryType"/>
                        </ww:param>
                    </ww:component>

                    <ww:checkbox name="active" fieldValue="true">
                        <ww:param name="label" value="getText('directory.active.label')"/>
                    </ww:checkbox>
                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        <input type="submit" class="button"
                               value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewinternal" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
</body>
</html>