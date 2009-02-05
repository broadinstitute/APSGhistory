<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('dataimport.importatlassian.title')"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.atlassian')"/>"/>

    <script type="text/javascript" language="javascript">

        var internalAtlassianSHA1Directories = new Array(
                
                    <ww:iterator value="internalAtlassianSHA1directories" status="currentdir">
                        "<ww:property value="ID" />"<ww:if test="!#currentdir.last">,</ww:if>
                    </ww:iterator>
                );
        function init()
        {
            hideShowPasswordImport();
        }

        function hideShowPasswordImport()
        {
            // Get the form and check the current value of the directory select
            var form = document.dataimport;

            var directoryId = form.configuration_directoryID.value;

            for (var i = 0; i < internalAtlassianSHA1Directories.length; i++)
            {
                var internalSHA1ID = internalAtlassianSHA1Directories[i];
                if (internalSHA1ID == directoryId)
                {
                    // display the password
                    document.getElementById("password_import").style.display="block";
                    form.configuration_importPasswords.checked = true;
                    break;
                }
                else
                {
                    document.getElementById("password_import").style.display="none";
                    form.configuration_importPasswords.checked = false;
                }
            }
        }


    </script>

</head>
<body onload="init();">

<h2>
    <ww:property value="getText('dataimport.importatlassian.title')"/>
</h2>

<div class="page-content">
    <ul class="tabs">

        <li>
                    <span class="tab">
                        1. <ww:property value="getText('dataimport.type.label')"/>
                    </span>

        </li>

        <li class="on">
                    <span class="tab">
                        2. <ww:property value="getText('dataimport.options.label')"/>
                    </span>
        </li>

        <li>
                    <span class="tab">
                        3. <ww:property value="getText('dataimport.result.label')"/>
                    </span>
        </li>

    </ul>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="titleSection">
                <ww:property value="getText('dataimport.importatlassian.text')"/>
            </div>
                                        
            <form name="dataimport" method="post"
                  action="<ww:url namespace="/console/secure/dataimport" action="importatlassian" method="import" includeParams="none"/>">

                <div class="formBody">
                    <ww:component template="form_messages.jsp"/>

                    <ww:select name="configuration.application" list="atlassianApplications" listKey="key" listValue="value">
                        <ww:param name="label" value="getText('dataimport.importatlassian.product.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('dataimport.importatlassian.product.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                        <ww:select name="configuration.directoryID" list="directories" listKey="ID" listValue="name" onchange="javascript:hideShowPasswordImport();">
                        <ww:param name="label" value="getText('dataimport.importdirectory.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('dataimport.importdirectory.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                    <span id="password_import">
                    <ww:checkbox name="configuration.importPasswords" >
                        <ww:param name="label" value="getText('dataimport.importpassword.label')"/>
                        <ww:param name="description" value="getText('dataimport.importpassword.description')" />
                    </ww:checkbox>
                    </span>

                    <ww:textfield name="configuration.databaseURL" size="50" required="true">
                        <ww:param name="label" value="getText('dataimport.importdburl.label')"/>
                    </ww:textfield>

                    <ww:textfield name="configuration.databaseDriver" size="50" required="true">
                        <ww:param name="label" value="getText('dataimport.importdriver.label')"/>
                    </ww:textfield>

                    <ww:textfield name="configuration.username" required="true">
                        <ww:param name="label" value="getText('dataimport.importdbusername.label')"/>
                    </ww:textfield>

                    <ww:password name="configuration.password">
                        <ww:param name="label" value="getText('dataimport.importdbpassword.label')"/>
                    </ww:password>
                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">


                        <input type="submit" class="button"
                               value="<ww:property value="getText('continue.label')"/> &raquo;"/>

                        <ww:if test="directory.type.code == 1">
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewinternal" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                        </ww:if>
                        <ww:elseif test="directory.type.code == 2">
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewconnector" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                        </ww:elseif>
                        <ww:else>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewcustom" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                        </ww:else>

                    </div>
                </div>

            </form>

        </div>

    </div>
</div>
</body>
</html>