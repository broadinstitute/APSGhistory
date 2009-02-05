<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('generalconfiguration.title')"/></title>
        <meta name="section" content="administration" />
        <meta name="subsection" content="generalconfiguration" />
    </head>

    <body>
    


        <form method="post" action="<ww:url namespace="/secure/admin" action="updateoptions" method="update" includeParams="none"/>" name="editprofiles">

            <div class="crowdForm">

                <h2><ww:property value="getText('generalconfiguration.title')"/></h2>

                <ww:include value="/include/generic_errors.jsp"/>

                <div class="titleSection">
                    <ww:property value="getText('generalconfiguration.baseurl.title')"/>
                </div>

                <div class="formBodyNoTop">

                    <ww:textfield name="baseURL" size="60">
                        <ww:param name="value" value="baseURL"/>
                        <ww:param name="label">
                            <ww:property value="getText('generalconfiguration.baseurl.label')"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:property value="getText('generalconfiguration.baseurl.description')"/>
                        </ww:param>
                    </ww:textfield>

                </div>

                <div class="titleSection">
                    <ww:property value="getText('generalconfiguration.options.title')"/>
                </div>

                <div class="formBodyNoTop">

                    <ww:checkbox name="enableRelyingPartyLocalhostMode" fieldValue="true">
                        <ww:param name="label" value="getText('generalconfiguration.rplocalhost.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('generalconfiguration.rplocalhost.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <ww:checkbox name="enableCheckImmediateMode" fieldValue="true">
                        <ww:param name="label" value="getText('generalconfiguration.checkimmediate.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('generalconfiguration.checkimmediate.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <ww:checkbox name="enableStatelessMode" fieldValue="true">
                        <ww:param name="label" value="getText('generalconfiguration.stateless.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('generalconfiguration.stateless.description')"/>
                        </ww:param>
                    </ww:checkbox>

                </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/secure/admin" action="viewoptions" includeParams="none"/>';"/>
                    </div>
                </div>                

            </div>
        </form>

    </body>
</html>