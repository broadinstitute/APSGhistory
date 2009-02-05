<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('dataimport.csv.title')"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.csv')"/>"/>
</head>
<body>

<h2>
    <ww:property value="getText('dataimport.csv.title')"/>
</h2>

<div class="page-content">
    <ol class="tabs">

        <li class="on">
            <span class="tab">1.&nbsp;<ww:property value="getText('dataimport.csv.configuration.label')"/></span>
        </li>
        <li>
            <span class="tab">2.&nbsp;<ww:property value="getText('dataimport.csv.mapping.label')"/></span>
        </li>
        <li>
            <span class="tab">3.&nbsp;<ww:property value="getText('dataimport.csv.confirmation.label')"/></span>
        </li>
        <li>
            <span class="tab">4.&nbsp;<ww:property value="getText('dataimport.result.label')"/></span>
        </li>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="titleSection">
                <ww:property value="getText('dataimport.csv.import.text')"/>
            </div>

            <form name="dataimport" method="post"
                  action="<ww:url namespace="/console/secure/dataimport" action="importcsv" method="doExecute" includeParams="none"/>">

                <div class="formBody">
                    <ww:component template="form_messages.jsp"/>


                    <ww:select name="directoryID" list="directories" listKey="ID" listValue="name">
                        <ww:param name="label" value="getText('dataimport.importdirectory.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('dataimport.importdirectory.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                    <ww:radio 
                            list="passwordsEncrypted"
                            name="encryptedPasswords"
                            required="true"
                            listKey="key"
                            listValue="value"
                            >
                        <ww:param name="label" value="getText('dataimport.csv.encryptedpasswords.label')" />                        
                        <ww:param name="description" value="getText('dataimport.csv.encryptedpasswords.description')" />
                    </ww:radio>

                    <ww:textfield name="delimiter">
                        <ww:param name="size" value="5"/>
                        <ww:param name="required" value="true"/>
                        <ww:param name="maxlength" value="1"/>
                        <ww:param name="cssStyle" value="'text-align:center;'"/>
                        <ww:param name="label" value="getText('dataimport.csv.delimiter.label')"/>
                        <ww:param name="description" value="getText('dataimport.csv.delimiter.description')"/>
                    </ww:textfield>

                    <ww:textfield name="users" required="true">
                        <ww:param name="label" value="getText('dataimport.csv.userfile.label')"/>
                        <ww:param name="description" value="getText('dataimport.csv.userfile.description')"/>
                        <ww:param name="size" value="30"/>
                    </ww:textfield>

                    <ww:textfield name="groupMemberships">
                        <ww:param name="label" value="getText('dataimport.csv.groupmembershipfile.label')"/>
                        <ww:param name="size" value="30"/>
                        <ww:param name="description" value="getText('dataimport.csv.groupmembershipfile.description')"/>
                    </ww:textfield>

                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">


                        <input type="submit" class="button"
                               value="<ww:property value="getText('continue.label')"/> &raquo;"/>

                    </div>
                </div>

            </form>

        </div>

    </div>
</div>
</body>
</html>