<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="database.title"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.installtype')"/>"/>

    <script type="text/javascript">

    </script>
</head>
<body>


<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/setup" action="installtype" method="update" />" name="install">

        <div class="formTitle">
            <h2>
               <ww:text name="install.title"/>
            </h2>
        </div>

        <div class="formBody">
            <p>
                <ww:text name="install.text"/>
            </p>

            <ww:component template="form_messages.jsp"/>

            <!-- old school html required because webwork rendering isn't ubertacular -->

            <div class="vertical-options">
                <input type="radio" id="radioNewInstall" name="installOption" value="<ww:property value="newInstallValue"/>" <ww:if test="newInstallSelected">checked</ww:if>/>
                <label for="radioNewInstall"><ww:text name="install.new.label"/></label>
                <div class="vertical-option-description">
                    <ww:text name="install.new.description"/>
                </div>

                <br/>

                <input type="radio" id="radioXmlInstall" name="installOption" value="<ww:property value="xmlInstallValue"/>" <ww:if test="xmlInstallSelected">checked</ww:if>/>
                <label for="radioXmlInstall"><ww:text name="install.upgrade.xml.label"/></label>
                <div class="vertical-option-description">
                    <ww:text name="install.upgrade.xml.description"/>
                </div>

                <br/>

                <input type="radio" id="radioDbInstall" name="installOption" value="<ww:property value="dbInstallValue"/>" <ww:if test="dbInstallSelected">checked</ww:if>/>
                <label for="radioDbInstall"><ww:text name="install.upgrade.db.label"/></label>
                <div class="vertical-option-description">
                    <ww:text name="install.upgrade.db.description"/>
                </div>

                <br/>

            </div>



        </div>

        <div class="formFooter wizardFooter">
            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
            </div>
        </div>

    </form>

</div>



</body>
</html>