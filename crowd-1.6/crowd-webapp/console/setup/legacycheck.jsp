<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="legacy.title"/>
    </title>
</head>
<body>


<div class="crowdForm">

    <div class="formTitle">
        <h2>
            <ww:text name="legacy.title"/>
        </h2>
    </div>

    <div class="formBody">
        <p class="warning-box">
            <ww:text name="legacy.error"/>
        </p>

        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('legacy.build.label')" />
            <ww:param name="value">
                <ww:property value="dataBuild"/>
            </ww:param>
        </ww:component>

        <p>
            <ww:text name="legacy.text"/>
        </p>
    </div>

    <div class="formFooter wizardFooter">
        <div class="buttons">
            &nbsp;
        </div>
    </div>

</div>



</body>
</html>