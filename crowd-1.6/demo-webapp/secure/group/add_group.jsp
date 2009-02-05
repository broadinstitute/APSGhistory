<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('menu.addgroup.label')"/></title>
        <meta name="section" content="groups" />
    </head>
    <body>

<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/secure/group" action="addgroup" method="update" includeParams="none"/>">

        <div class="formTitle">
            <h2>
                <ww:property value="getText('menu.addgroup.label')"/>
            </h2>
        </div>

        <div class="formBody">

            <ww:include value="/include/generic_errors.jsp"/>

            <ww:textfield name="name" size="'35px;'">
                <ww:param name="label" value="getText('group.name.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('group.name.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="groupDescription" size="'35px;'">
                <ww:param name="label" value="getText('group.description.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('group.description.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:checkbox name="active" fieldValue="true">
                <ww:param name="label" value="getText('group.active.label')"/>
            </ww:checkbox>
        </div>

        <div class="formFooter wizardFooter">

            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('create.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/secure/group" action="browsegroups" includeParams="none" />';"/>
            </div>
        </div>

    </form>

</div>

    <%--<div class="crowdForm">--%>
            <%--<h2><ww:property value="getText('menu.addgroup.label')"/></h2>--%>

            <%--<p>--%>
                <%--<form method="post" action="<ww:url namespace="/secure/group" action="addgroup" method="update" includeParams="none" />">--%>

                    <%--<ww:if test="actionErrors">--%>
                        <%--<ww:iterator value="actionErrors">--%>
                            <%--<p class="error">--%>
                                <%--<ww:property /><br/>--%>
                            <%--</p>--%>
                        <%--</ww:iterator>--%>
                    <%--</ww:if>--%>

                    <%--<ww:textfield name="name" size="35px;" >--%>
                        <%--<ww:param name="label" value="getText('group.name.label')" />--%>
                        <%--<ww:param name="description"><ww:property value="getText('group.name.description')"/></ww:param>--%>
                    <%--</ww:textfield>--%>

                    <%--<ww:textfield name="description" size="35px;" >--%>
                        <%--<ww:param name="label" value="getText('group.description.label')" />--%>
                        <%--<ww:param name="description"><ww:property value="getText('group.description.description')"/></ww:param>--%>
                    <%--</ww:textfield>--%>

                    <%--<ww:checkbox name="active" fieldValue="true">--%>
                        <%--<ww:param name="label" value="getText('group.active.label')" />--%>
                    <%--</ww:checkbox>--%>

                    <%--<div class="row">--%>
                        <%--<span class="value">--%>
                            <%--<p style="text-align: right">--%>
                                <%--<input type="submit" class="button" value="<ww:property value="getText('create.label')"/> &raquo;" />--%>
                                <%--<input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/secure/group" action="browsegroups" includeParams="none" />';"/>--%>
                            <%--</p>--%>
                        <%--</span>--%>
                    <%--</div>--%>

                <%--</form>--%>
            <%--</p>--%>
    </body>
</html>