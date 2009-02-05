<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="license.title"/>
    </title>
</head>

<body>

    <div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console" action="license" method="update" />">


        <div class="formTitle">
            <h2>
                <ww:text name="license.title"/>
            </h2>
        </div>

        <div class="formBodyNoTop">

        <p style="font-weight:bold;">
        <ww:if test="license.expired">
            <ww:property value="getText('license.invalid.expired.text')"/>
        </ww:if>
        <ww:elseif test="atResourceLimit">
            <ww:property value="getText('license.invalid.limitreached.text')"/>
        </ww:elseif>
        </p>


        <ww:component template="form_messages.jsp"/>
        
        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.organization.label')" />
            <ww:param name="value">
                    <ww:property value="license.organisation.name" />
            </ww:param>
        </ww:component>

        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.type.label')" />
            <ww:param name="value">
                    <ww:property value="license.description" />
            </ww:param>
        </ww:component>

        <ww:if test="!license.evaluation">
        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.datepurchased.label')" />
            <ww:param name="value">
                    <ww:date format="EEEE, dd MMM yyyy" name="license.purchaseDate"/>
            </ww:param>
        </ww:component>
        </ww:if>

        <ww:if test="license.supportEntitlementNumber != null">
        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.sen.label')" />
            <ww:param name="value">
                    <ww:property value="license.supportEntitlementNumber" />
            </ww:param>
        </ww:component>
        </ww:if>

        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.supportperiod.label')" />
            <ww:param name="value">
                    <ww:if test="license.evaluation">
                        <ww:text name="license.supportperiod.evaluation.description"/>
                    </ww:if>
                    <ww:else>
                        <ww:text name="license.supportperiod.description"/>
                    </ww:else>
                &nbsp;<strong><ww:date format="EEEE, dd MMM yyyy" name="license.maintenanceExpiryDate"/></strong>
            </ww:param>
        </ww:component>

        <ww:if test="license.partner" >
            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('license.partner.label')" />
                <ww:param name="value">
                        <ww:property value="license.partner.name"/>
                </ww:param>
            </ww:component>
        </ww:if>

        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.userlimit.label')" />
            <ww:param name="value">
                <ww:if test="license.unlimitedNumberOfUsers" >
                    <ww:text name="license.unlimited.label"/>
                </ww:if>
                <ww:else>
                    <ww:property value="license.maximumNumberOfUsers" />
                </ww:else>
            </ww:param>
        </ww:component>

        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('license.userresources.label')" />
            <ww:param name="value">
                    <ww:property value="currentResources" />
            </ww:param>
        </ww:component>

        <ww:component template="form_row.jsp">
            <ww:param name="label" value="getText('systeminfo.serverid.label')" />
            <ww:param name="value">
                    <ww:property value="crowdSid" />
            </ww:param>
        </ww:component>
                        
        <ww:textfield name="username" size="30">
            <ww:param name="label" value="getText('username.label')"/>
        </ww:textfield>


        <ww:password name="password" size="30">
            <ww:param name="label" value="getText('password.label')"/>
        </ww:password>

        <ww:textarea name="key" rows="8" cols="60">
            <ww:param name="label">
                <ww:property value="getText('license.key.label')"/>
            </ww:param>
        </ww:textarea>

        <p class="subtext"><ww:text name="license.key.description.1"/>
                <a href="<ww:url value="http://www.atlassian.com/ex/GenerateLicense.jspa">
                    <ww:param name="product" value="getText('application.name')" />
                    <ww:param name="version" value="@com.atlassian.crowd.util.build.BuildUtils@BUILD_VERSION" />
                    <ww:param name="sid" value="crowdSid" />
                    <ww:param name="ref" value="'prod'" />
                </ww:url>"><ww:text name="license.key.description.2"/></a>
                &nbsp;<ww:text name="license.key.description.3">
                <ww:param id="0"><a  href="<ww:url value="http://my.atlassian.com/" includeParams="none"/>"></ww:param>
                <ww:param id="1"></a></ww:param>
                </ww:text>
            </p>
        
        <div class="formFooter wizardFooter">

            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
            </div>
        </div>

        </div>

    </form>

    </div>

</body>
</html>