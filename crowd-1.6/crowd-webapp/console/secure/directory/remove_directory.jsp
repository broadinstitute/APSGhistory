<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('directory.remove.title')"/>
    </title>
    <meta name="section" content="directories"/>
    <meta name="pagename" content="remove"/>
</head>
<body>


    <div class="crowdForm">
        <div class="formTitle">
            <h2>
                <ww:property value="getText('directory.remove.title')"/>
                &nbsp;&ndash;&nbsp;
                <ww:property value="directory.name"/>
            </h2>
        </div>

        <div class="formBody">

            <ww:component template="form_messages.jsp"/>

            <ww:component template="form_row.jsp">
                <ww:param name="warning" value="getText('directory.remove.text')" />
               <ww:param name="label" value="getText('directory.name.label')" />
               <ww:param name="value" value="directory.name" />
               <ww:param name="description" value=""/>
            </ww:component>


            <ww:component template="form_row.jsp">
               <ww:param name="label" value="getText('directory.type.label')" />
                <ww:param name="value">
                        <ww:property value="directory.implementation.directoryType"/>
                </ww:param>
            </ww:component>

        </div>

        <div class="formFooter wizardFooter">

            <div class="buttons">

                <form method="post" action="<ww:url namespace="/console/secure/directory" action="remove" method="update" includeParams="none"/>">

                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                    <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>

                    <ww:if test="directory.type.code == 1">
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewinternal" method="default" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                    </ww:if>
                    <ww:elseif test="directory.type.code == 2">
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewconnector" method="default" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                    </ww:elseif>
                    <ww:else>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewcustom" method="default" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                    </ww:else>

                </form>
            </div>

        </div>

    </div>


</body>
</html>