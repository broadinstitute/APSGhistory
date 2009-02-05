<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.addapplication.label')"/>
    </title>
    <meta name="section" content="applications"/>
    <meta name="pagename" content="add"/>
    <meta name="help.url" content="<ww:property value="getText('help.application.add')"/>"/>

    <script type="text/javascript">
        function resolveIpAddress()
        {
            var form = document.addapplicationconnectiondetails;
            form.action = '<ww:url namespace="/console/secure/application" action="addapplicationconnectiondetails" method="resolveIPAddress" includeParams="none"/>';
            form.submit();
        }
    </script>

</head>
<body>

<h2>
    <ww:property value="getText('menu.addapplication.label')"/> - <ww:property value="configuration.name"/>
</h2>

<div class="page-content">

    <ul class="tabs">
        <li id="hreftab1">
            <a href="<ww:url action="addapplicationdetails" namespace="/console/secure/application" includeParams="none"/>">1. <ww:property
                    value="getText('menu.details.label')"/></a>
        </li>

        <li class="on" id="hreftab2">
            <span class="tab">2. <ww:property value="getText('menu.connection.label')"/></span>
        </li>

        <li id="hreftab3">
            <span class="tab">3. <ww:property value="getText('menu.directory.label')"/></span>
        </li>

        <li id="hreftab4">
            <span class="tab">4. <ww:property value="getText('menu.authorisation.label')"/></span>
        </li>

        <li id="hreftab5">
            <span class="tab">5. <ww:property value="getText('menu.confirmation.label')"/></span>
        </li>
    </ul>

    <div class="crowdForm">

        <form name="addapplicationconnectiondetails" method="post"
              action="<ww:url namespace="/console/secure/application" action="addapplicationconnectiondetails" method="completeStep" includeParams="none"/>">

            <div class="formBodyNoTop">

                <ww:component template="form_messages.jsp"/>

                <div class="fieldArea required">
                    <ww:if test="fieldErrors['applicationURL'] != null">
                    <div class="errorBox">
                        <ww:iterator value="fieldErrors['applicationURL']">
                            <ww:property /><br />
                        </ww:iterator>
                    </div>
                    </ww:if>
                    <label class="fieldLabelArea" for="applicationURL"><span class="required">*</span><ww:text name="application.url.label"/>:</label>
                    <div class="fieldValueArea">
                        <input name="applicationURL" size="35" value="<ww:property value="applicationURL"/>" id="applicationURL" type="text">
                        <input type="button" value="Resolve IP Address" style="margin-left:20px;" onclick="resolveIpAddress();"/>
                        <div class="fieldDescription">
                            <ww:text name="application.url.description"/>
                        </div>
                    </div>
                </div>

                <ww:textfield name="remoteIPAddress" size="35px;">
                    <ww:param name="label" value="getText('application.remoteipaddress.label')"/>
                    <ww:param name="required" value="true"/>
                    <ww:param name="description">
                        <ww:property value="getText('application.remoteipaddress.description')"/>
                    </ww:param>
                </ww:textfield>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('next.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="addapplicationdetails" method="cancel" />';"/>

                </div>

            </div>

        </form>

    </div>
</div>

</body>
</html>