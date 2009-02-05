<%@ taglib uri="/webwork" prefix="ww" %>

<html>
    <head>
        <title><ww:text name="setupcomplete.title"/></title>
        <meta name="help.url" content="<ww:text name="help.setup.complete"/>"/>
    </head>
    <body>

    <div class="crowdForm">

        <div class="formTitle">
            <h2><ww:text name="setupcomplete.title"/></h2>
        </div>

        <div class="formBody">
            <ww:component template="form_messages.jsp"/>

            <ww:if test="hasErrors() == false">
                <p><ww:text name="setupcomplete.text"/></p>
            </ww:if>
            <ww:else>
                <ww:text name="setupcomplete.error.text"/>
            </ww:else>
        </div>

        <ww:if test="hasErrors() == false">
        <div class="formFooter wizardFooter">
            <div class="buttons">
                <input id="continueButton" type="button" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;" onClick="window.location='<ww:url value="/console/" />';"/>
            </div>
        </div>
        </ww:if>

    </div>

    </body>
</html>