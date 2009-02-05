<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="console.title"/>
    </title>
    <meta name="section" content="home"/>
    <meta name="help" content="<ww:text name="help.home"/>"/>
</head>

<body>
    
    <h2>
        <ww:text name="console.welcome"/>
    </h2>

    <div class="page-content">

        <p>
            <ww:text name="console.text.intro"/>
        </p>

        <p>
            <b><ww:text name="console.text.bold"/></b>
        </p>

        <p>
            <div class="bulleted-ul">
                <ww:property value="getText('console.text.html')" escape="false"/>
            </div>
        </p>

        <ww:if test="nearExpiredLicnese == true || atResourceLimit == true || licenseExpired == true || license.evaluation == true || license.maintenanceExpired == true">
        <p class="warningBox">
            <ww:if test="nearExpiredLicnese == true">
                <ww:text name="license.maintenance.expires.soon">
                    <ww:param name="value0" value="expiryDate"/>
                    <ww:param name="value1" value="daysLeft"/>
                    <ww:param name="value2" value="'<a href=\"https://www.atlassian.com/software/Buy.jspa?action=renew\">'"/>
                    <ww:param name="value3" value="'</a>'"/>
                    <ww:param name="value4" value="'<a href=\"http://www.atlassian.com/software/crowd/learn/whyrenew.jsp\">'"/>
                    <ww:param name="value5" value="'</a>'"/>

                </ww:text>
            </ww:if>
            <ww:if test="atResourceLimit == true">
                <ww:text name="license.resource.limit">
                    <ww:param name="value0" value="license.users"/>
                    <ww:param name="value1" value="currentLicenseResourceTotal"/>
                    <ww:param name="value2" value="'<a href=\"https://www.atlassian.com/software/Buy.jspa?action=renew\">'"/>
                    <ww:param name="value3" value="'</a>'"/>
                    <ww:param name="value4" value="'<a href=\"http://www.atlassian.com/software/crowd/licensing-faq.jsp#upgrade_update\">'"/>
                    <ww:param name="value5" value="'</a>'"/>
                </ww:text>
            </ww:if>
            <ww:if test="licenseExpired == true">
                <ww:text name="license.expired"/>
            </ww:if>
            <ww:if test="license.maintenanceExpired == true">
                <ww:text name="license.maintenance.expired">
                    <ww:param name="value0" ><ww:date format="dd MMM yyyy" name="license.maintenanceExpiryDate"/></ww:param>
                    <ww:param name="value1" value="'<a href=\"https://www.atlassian.com/software/Buy.jspa?action=renew\">'"/>
                    <ww:param name="value2" value="'</a>'"/>
                    <ww:param name="value3" value="'<a href=\"http://www.atlassian.com/software/crowd/learn/whyrenew.jsp\">'"/>
                    <ww:param name="value4" value="'</a>'"/>
                </ww:text>
            </ww:if>
            <ww:if test="evaluation == true">
                <ww:text name="license.evaluation.purchase">
                    <ww:param name="value0" value="'<a href=\"http://www.atlassian.com/software/crowd\">'"/>
                    <ww:param name="value1" value="'</a>'"/>
                </ww:text>
            </ww:if>
        </p>
        </ww:if>

    </div>
</body>
</html>