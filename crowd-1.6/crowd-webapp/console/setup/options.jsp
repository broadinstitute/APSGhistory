<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('options.title')"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.options')"/>"/>
</head>
<body>


<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/setup" action="setupoptions" method="update" />" name="options">

        <div class="formTitle">
            <h2>
                <ww:property value="getText('options.title')"/>
            </h2>
        </div>

        <div class="formBody">
            <ww:component template="form_messages.jsp"/>

            <ww:textfield name="title">
                <ww:param name="value" value="title"/>
                <ww:param name="label">
                    <ww:property value="getText('options.title.label')"/>
                </ww:param>
                <ww:param name="description">
                    <ww:property value="getText('options.title.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="sessionTime">
                <ww:param name="value" value="sessionTime"/>
                <ww:param name="label">
                    <ww:property value="getText('session.sessiontime.label')"/>
                </ww:param>
                <ww:param name="description">
                    <ww:property value="getText('session.sessiontime.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="baseURL">
                <ww:param name="value" value="baseURL"/>
                <ww:param name="label">
                    <ww:property value="getText('options.base.url.label')"/>
                </ww:param>
                <ww:param name="size">40</ww:param>
                <ww:param name="description">
                    <ww:property value="getText('options.base.url.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
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