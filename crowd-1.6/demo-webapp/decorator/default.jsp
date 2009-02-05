<%@ taglib uri="sitemesh-decorator" prefix="decorator" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

    <decorator:usePage id="sitemeshPage"/>

    <title>
        <ww:property value="getText('application.title')"/>&nbsp;-&nbsp;<decorator:title/>
    </title>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="author" content="Atlassian"/>
    <meta name="robots" content="all"/>

    <meta name="MSSmartTagsPreventParsing" content="true"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>

    <link rel="shortcut icon" href="<ww:url value="/favicon.ico"/>">

    <decorator:head/>

    <style type="text/css" media="all">
        @import "<ww:url value="/style/main.css" includeParams="none"/>";
        @import "<ww:url value="/style/forms.css" includeParams="none"/>";
        @import "<ww:url value="/style/idx-legacy.css" includeParams="none"/>";
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
            <a href="<ww:url value="/"/>"><img alt="<ww:text name="application.name"/>" src="<ww:url value="/images/logo.gif"/>" height="36" width="118"/></a>
        </div>

        <ul id="userOptions">
            <ww:if test="authenticated == true">
                <li id="userInfo">
                    <ww:property value="getText('user.label')"/>:&nbsp;<strong>
                    <span id="userFullName"><ww:property value="principalName"/></span>
                </strong>
                </li>

                <li id="profileLink">
                    <a href="<ww:url namespace="/console" action="logoff" includeParams="none"/>">
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
                <a href="<ww:url namespace="/secure/console" action="console" includeParams="none"/>">
                    <ww:property value="getText('menu.console.label')"/>
                </a>
            </li>
            <ww:if test="authenticated == true ">

                <li <% if ("groups".equals(sitemeshPage.getProperty("meta.section"))) { %> class="on"<% } %>>
                    <a href="<ww:url namespace="/secure/group" action="browsegroups" includeParams="none" />">
                        <ww:property value="getText('menu.group.label')"/>
                    </a>
                </li>
                <li <% if ("principals".equals(sitemeshPage.getProperty("meta.section"))) { %> class="on"<% } %>>
                    <a href="<ww:url namespace="/secure/principal" action="browseprincipals" includeParams="none" />">
                        <ww:property value="getText('menu.principal.label')"/>
                    </a>
                </li>
                <li <% if ("roles".equals(sitemeshPage.getProperty("meta.section"))) { %> class="on"<% } %>>
                    <a href="<ww:url namespace="/secure/role" action="browseroles" includeParams="none" />">
                        <ww:property value="getText('menu.role.label')"/>
                    </a>
                </li>
            </ww:if>
        </ul>
    </div>
    <!-- END #menu -->

    <div id="content">

        <div class="container">
            <decorator:body/>
        </div>

    </div>
    <!-- END #content -->
</div>
<!-- END #nonFooter -->

<div id="footer">
    <p>
        Powered by <a href="http://confluence.atlassian.com/display/CROWD">Atlassian Crowd</a>
        <ww:text name="common.words.version"/>:&nbsp;<ww:property value="@com.atlassian.crowd.util.build.BuildUtils@getVersion()"/>
    </p>
    <ul>
        <li class="first">
            <a href="http://jira.atlassian.com/browse/CWD">
                <ww:property value="getText('support.bug')"/>
            </a>

        </li>
        <li>
            <a href="http://jira.atlassian.com/browse/CWD">
                <ww:property value="getText('support.feature')"/>
            </a>
        </li>
        <li>
            <a href="http://www.atlassian.com/about/contact.jsp">
                <ww:property value="getText('support.contact')"/>
            </a>
        </li>
    </ul>
</div>
<!-- END #footer -->

</body>

</html>