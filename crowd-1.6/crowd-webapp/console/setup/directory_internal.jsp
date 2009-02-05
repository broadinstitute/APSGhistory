<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('directoryinternal.title')"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.internaldirectory')"/>"/>
</head>
<body>

<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/setup" action="directoryinternalsetup" method="update" />" name="directoryinternal">

        <div class="formTitle">
            <h2>
                <ww:property value="getText('directoryinternal.title')"/>
            </h2>
        </div>

        <div class="formBody">

            <ww:component template="form_messages.jsp"/>

            <ww:textfield name="name" size="50">
                <ww:param name="label" value="getText('directoryinternal.name.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryinternal.name.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="description" size="50">
                <ww:param name="label" value="getText('directoryinternal.description.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryinternal.description.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:textfield name="passwordRegex" size="50">
                <ww:param name="label" value="getText('directoryinternal.passwordregex.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryinternal.passwordregex.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:textfield name="passwordMaxAttempts">
                <ww:param name="label" value="getText('directoryinternal.passwordmaxattempts.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryinternal.passwordmaxattempts.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:textfield name="passwordMaxChangeTime">
                <ww:param name="label" value="getText('directoryinternal.passwordmaxchangetime.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryinternal.passwordmaxchangetime.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:textfield name="passwordHistoryCount">
                <ww:param name="label" value="getText('directoryinternal.passwordhistorycount.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryinternal.passwordhistorycount.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:select list="userEncryptionMethods" name="userEncryptionMethod" listKey="key" listValue="value" required="true">
                <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('directoryconnector.userencryptionmethod.internal.description')"/>
                </ww:param>
            </ww:select>
            
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