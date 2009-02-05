<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('setup.import.title')"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.import')"/>"/>
</head>
<body>


<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/setup" action="setupimport" method="doUpdate"/>" name="import">

        <div class="formTitle">
            <h2>
                <ww:property value="getText('setup.import.title')"/>
            </h2>
        </div>

        <div class="formBody">
            <p>
                <ww:text name="setup.import.text"/>
            </p>

            <ww:component template="form_messages.jsp"/>

            <ww:textfield name="filePath" size="50">
                <ww:param name="label" value="getText('setup.import.filepath.label')"/>
                <ww:param name="description" value="getText('setup.import.filepath.description')"/>
            </ww:textfield>

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