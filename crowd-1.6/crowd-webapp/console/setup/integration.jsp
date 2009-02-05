<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('integration.title')"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.integratedapps')"/>"/>
</head>
<body>

        <form method="post" action="<ww:url namespace="/console/setup" action="integration" method="update" />" name="integration">

            <div class="crowdForm">

                <h2><ww:property value="getText('integration.title')"/></h2>

                <ww:component template="form_messages.jsp"/>

                <div class="titleSection">
                    <ww:property value="getText('integration.text')"/>
                </div>

                <div class="formBodyNoTop">

                <ww:radio list="enableDisableOptions" name="configureOpenIDServer" listKey="key" listValue="value">
                    <ww:param name="label" value="getText('integration.openidserver.label')"/>

                    <ww:param name="description">
                        <ww:property value="getText('integration.openidserver.description')"/>
                    </ww:param>
                </ww:radio>

                <ww:radio list="enableDisableOptions" name="configureDemoApp" listKey="key" listValue="value">
                    <ww:param name="label" value="getText('integration.demoapp.label')"/>

                    <ww:param name="description">
                        <ww:property value="getText('integration.demoapp.description')"/>
                    </ww:param>
                </ww:radio>

                </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                    </div>
                </div>

            </div>
        </form>


</body>
</html>