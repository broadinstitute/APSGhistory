<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="mailserver.title"/>
    </title>
    <meta name="help.url" content="<ww:text name="help.setup.mailserver"/>"/>

    <script language="JavaScript" type="text/javascript">

        function hideAndDisplayDiv(hiddenDiv, displayedDiv)
        {
            var divTodisplay = document.getElementById(displayedDiv);
            divTodisplay.style.display="block";


            var divTohide = document.getElementById(hiddenDiv);
            divTohide.style.display = "none";
        }
        
        function autoClick()
        {
            if (document.getElementById('radioSMTPOption').checked)
            {
                hideAndDisplayDiv('jndi-configuration', 'smtp-configuration');
            }
            else if (document.getElementById('radioJNDIOption').checked)
            {
                hideAndDisplayDiv('smtp-configuration', 'jndi-configuration');
            }
        }
    </script>
</head>


<body onload="autoClick();">

    <h2>
        <ww:text name="mailserver.configuration.label"/>
    </h2>

    <div class="crowdForm">

        <form method="post" action="<ww:url namespace="/console/setup" action="mailserver" method="update" />" name="mailserver">

        <ww:component template="form_messages.jsp"/>

        <div class="formBody">


            <ww:textfield name="notificationEmail" size="50">
                <ww:param name="label" value="getText('mailserver.notification.label')"/>
                <ww:param name="required" value="true" />
                <ww:param name="description"><ww:property
                    value="getText('mailserver.notification.description')"/></ww:param>
            </ww:textfield>


            <ww:textfield name="from" size="50">
                <ww:param name="label" value="getText('mailserver.from.label')"/>
                <ww:param name="required" value="true" />
                <ww:param name="description"><ww:property
                    value="getText('mailserver.from.description')"/></ww:param>
            </ww:textfield>

            <ww:textfield name="prefix" size="50">
                <ww:param name="label" value="getText('mailserver.prefix.label')"/>
                <ww:param name="description"><ww:property
                    value="getText('mailserver.prefix.description')"/></ww:param>
            </ww:textfield>

            <h3><ww:text name="mailserver.serverdetails.label"/></h3>

            <div class="fieldArea">

                <label for="mailSelection" class="fieldLabelArea"><ww:text name="mailserver.jndi.smtp.label"/>:</label>
                <div id="mailSelection" class="fieldValueArea">
                    <input type="radio" id="radioSMTPOption" name="jndiMailActive" value="false" onclick="hideAndDisplayDiv('jndi-configuration', 'smtp-configuration');" <ww:if test="jndiMailActive == 'false'">checked="checked"</ww:if> /><label for="radioSMTPOption"><ww:text name="mailserver.smtphost.label"/></label>
                    &nbsp;
                    <input type="radio" id="radioJNDIOption" name="jndiMailActive" value="true" onclick="hideAndDisplayDiv('smtp-configuration', 'jndi-configuration');" <ww:if test="jndiMailActive == 'true'">checked="checked"</ww:if> /><label for="radioJNDIOption"><ww:text name="mailserver.jndilocation.label"/></label>
                </div>
                <div class="fieldDescription">
                    <ww:text name="mailserver.jndi.smtp.description" />
                </div>

            </div>



            <div id="smtp-configuration">

                <div class="sectionSubTitle"><ww:text name="mailserver.smtphost.label"/></div>

                <ww:textfield name="host" size="50">
                    <ww:param name="label" value="getText('mailserver.host.label')"/>
                    <ww:param name="required" value="true" />
                    <ww:param name="description"><ww:property
                            value="getText('mailserver.host.description')"/></ww:param>
                </ww:textfield>

                <ww:textfield name="port" size="10">
                    <ww:param name="label" value="getText('mailserver.port.label')"/>
                    <ww:param name="description"><ww:property
                            value="getText('mailserver.port.description')"/></ww:param>
                </ww:textfield>

                <ww:textfield name="username">
                    <ww:param name="label" value="getText('mailserver.username.label')"/>
                    <ww:param name="description"><ww:property
                            value="getText('mailserver.username.description')"/></ww:param>
                </ww:textfield>

                <ww:password name="password">
                    <ww:param name="label" value="getText('mailserver.password.label')"/>
                    <ww:param name="description"><ww:property
                            value="getText('mailserver.password.description')"/></ww:param>
                </ww:password>

            </div>

            <div  id="jndi-configuration">

                <div class="sectionSubTitle"><ww:text name="mailserver.jndilocation.label"/></div>

                <ww:textfield name="jndiLocation" size="50">
                    <ww:param name="label" value="getText('mailserver.jndiLocation.label')"/>
                    <ww:param name="required" value="true" />
                    <ww:param name="description"><ww:property
                            value="getText('mailserver.jndiLocation.description')"/></ww:param>
                </ww:textfield>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>

                </div>
            </div>

        </div>

    </form>

</div>

</body>
</html>
