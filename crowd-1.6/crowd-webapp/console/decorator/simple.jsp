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

    <link rel="shortcut icon" href="<ww:url value="/console/favicon.ico" includeParams="none"/>">

    <decorator:head/>

    <style type="text/css" media="all">
        @import "<ww:url value="/console/style/main.css" includeParams="none"/>";
        @import "<ww:url value="/console/style/forms.css" includeParams="none"/>";
        @import "<ww:url value="/console/style/idx-legacy.css" includeParams="none"/>";
    </style>
</head>

<body>

<ul id="top">
    <li id="skipNav">
        <a href="#menu">Skip to navigation</a>
    </li>
    <li>
        <a href="#content">Skip to content</a>
    </li>
</ul>
<div id="nonFooter">

    <!-- START #header -->
    <div id="header">
        <div id="logo">
            <a href="<ww:url value="/console" includeParams="none"/>"><img alt="<ww:text name="application.name"/>" src="<ww:url value="/console/images/logo.gif" includeParams="none"/>" height="36" width="118"/></a>
        </div>

        <ul id="userOptions">
            <li id="help">
                <a href="<ww:text name="application.documentation.url"/>">
                    <ww:text name="menu.documentation.label"/>
                </a>
            </li>
        </ul>
    </div>
    <!-- END #header -->

    <!-- START #content -->
    <div id="content">
        <decorator:body/>
    </div>
    <!-- END #content -->
</div>

<!-- START #footer -->
<div id="footer">
    <p>
        <ww:text name="footer.poweredby"/> <a href="<ww:text name="application.poweredby.url"/>"><ww:text name="application.title"/></a>
        <ww:text name="common.words.version"/>:&nbsp;<ww:property value="@com.atlassian.crowd.util.build.BuildUtils@getVersion()"/>
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
<!-- END #footer -->

</body>

</html>