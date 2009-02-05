<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('menu.addrole.label')"/></title>
        <meta name="section" content="roles" />
    </head>
    <body>
    <div class="crowdForm">
        <form method="post" action="<ww:url namespace="/secure/role" action="addrole" method="update" includeParams="none" />">

            <div class="formTitle">
                <h2>
                    <ww:property value="getText('menu.addrole.label')"/>
                </h2>
            </div>

            <div class="formBody">
                <ww:if test="actionErrors">
                    <ww:iterator value="actionErrors">
                        <p class="error">
                            <ww:property/>
                            <br/>
                        </p>
                    </ww:iterator>
                </ww:if>

                <ww:textfield name="name" size="35px;">
                    <ww:param name="label" value="getText('role.name.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('role.name.description')"/>
                    </ww:param>
                    <ww:param name="required" value="true"/>
                </ww:textfield>

                <ww:textfield name="description" size="35px;">
                    <ww:param name="label" value="getText('role.description.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('role.description.description')"/>
                    </ww:param>
                </ww:textfield>

                <ww:checkbox name="active" fieldValue="true">
                    <ww:param name="label" value="getText('role.active.label')"/>
                </ww:checkbox>
            </div>

            <div class="formFooter wizardFooter">
                <div class="buttons">
                    <input type="submit" class="button" value="<ww:property value="getText('create.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/secure/role" action="browseroles" includeParams="none" />';"/>
                </div>
            </div>

        </form>

    </div>
    </body>
</html>