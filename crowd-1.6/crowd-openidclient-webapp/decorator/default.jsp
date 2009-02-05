<%@ taglib uri="sitemesh-decorator" prefix="decorator" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

    <decorator:usePage id="sitemeshPage"/>

    <title>
        <ww:property value="getText('application.title')"/>
        -
        <decorator:title/>
    </title>

    <link rel="shortcut icon" href="<ww:url value="/favicon.ico" includeParams="none"/>">

    <decorator:head/>

    <style type="text/css" media="all">
        @import "<ww:url value="/style/main.css" includeParams="none"/>";
        @import "<ww:url value="/style/forms.css" includeParams="none"/>";
    </style>


</head>

<body onload="<decorator:getProperty property="body.onload" />">

<ul id="top">
    <li id="skipNav">
        <a href="#menu">Skip to navigation</a>
    </li>
    <li>
        <a href="#content">Skip to content</a>
    </li>
</ul>
<div id="nonFooter">

    <div id="header">
        <div id="logo">
            <a href="<ww:url value="/" includeParams="none"/>"><img src="<ww:url value="/images/logo.gif" includeParams="none"/>" height="36" width="160"/></a>
        </div>

        <ul id="userOptions">
            <ww:if test="authenticated == true">
                <li id="userInfo">
                    <ww:property value="getText('user.label')"/>:&nbsp;<strong>
                    <ww:property value="principalName"/>
                </strong>
                </li>

                <li id="userInfo">
                    &nbsp;
                    <ww:property value="getText('identifier.label')"/>:&nbsp;<strong>
                    <ww:property value="openIDPrincipal.identifier"/>
                </strong>
                </li>


                <li id="profileLink">
                    <a href="<ww:url namespace="/" action="logoff" includeParams="none"/>">
                        <ww:property value="getText('menu.logout.label')"/>
                    </a>
                </li>
            </ww:if>

            <li id="help">
                <a href="http://confluence.atlassian.com/display/CROWD/">
                    <ww:property value="getText('menu.documentation.label')"/>
                </a>
            </li>
            
        </ul>

    </div>
    <!-- END #header -->

    <div id="menu">
        <ul>
            <li <% if ("home".equals(sitemeshPage.getProperty("meta.section"))) { %> class="on"<% } %>>
                <a href="<ww:url value="/" includeParams="none" />"><ww:property value="getText('menu.home.label')"/></a>
            </li>

            <ww:if test="authenticated == true ">
                <li <% if ("profile".equals(sitemeshPage.getProperty("meta.section"))) { %> class="on"<% } %>>
                    <a href="<ww:url namespace="/secure" action="viewprofile" includeParams="none" />"><ww:property value="getText('menu.profile.label')"/></a>
                </li>
            </ww:if>
        </ul>
    </div>
    <!-- END #menu -->

    <div id="content">
        <decorator:body/>
    </div>
    <!-- END #content -->
</div>

<div id="footer">
    <p>
        <ww:text name="footer.poweredby"/> <a href="http://confluence.atlassian.com/display/CROWD"><ww:text name="application.title"/></a>
    </p>
    <ul>
        <li class="first">
            <a href="http://jira.atlassian.com/browse/CWD"><ww:text name="support.bug"/></a>
        </li>
        <li>
            <a href="http://jira.atlassian.com/browse/CWD"><ww:text name="support.feature"/></a>
        </li>
        <li>
            <a href="http://www.atlassian.com/about/contact.jsp"><ww:text name="support.contact"/></a>
        </li>
    </ul>
</div>
<!-- END #nonFooter -->

<!-- END #footer -->

</body>

</html>