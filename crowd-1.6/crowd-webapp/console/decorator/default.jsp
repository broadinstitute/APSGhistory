<%@ taglib uri="sitemesh-decorator" prefix="decorator" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

    <decorator:usePage id="sitemeshPage"/>

    <title>
        <ww:text name="application.title"/>&nbsp;-&nbsp;<decorator:title/>
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

    <!--[if IE 7]>
     <style type="text/css" media="all">
         @import "<ww:url value="/console/style/ie7.css" includeParams="none"/>";
     </style>
     <![endif]-->

    <!--[if IE 6]>
      <style type="text/css" media="all">
          @import "<ww:url value="/console/style/ie6.css" includeParams="none"/>";
      </style>
      <![endif]-->

    <ww:if test="licenseExpired == true || evaluation == true">
        <style type="text/css" xml:space="preserve">
            #footer {
                background-image: url( ../images/license_required.gif );
                background-color: #C33;
            }
        </style>
    </ww:if>

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
        <a href="<ww:url value="/console" includeParams="none"/>"><img alt="<ww:text name="application.name"/>" src="<ww:url value="/console/images/logo.gif" includeParams="none"/>" height="36" width="118"/></a>
    </div>

    <ul id="userOptions">
        <ww:if test="authenticated == true">
            <li id="userInfo">
                <ww:text name="user.label"/>:&nbsp;<strong>
                <span id="userFullName"><ww:property value="principalName"/></span>
            </strong>
            </li>

            <li id="profileLink">
                <a href="<ww:url namespace="/console" action="logoff" includeParams="none"/>">
                    <ww:text name="menu.logout.label"/>
                </a>
            </li>

            <ww:if test="admin == true">
                <li id="additionalOption">
                    <a href="<ww:url namespace="/console/user" action="viewprofile" includeParams="none"/>">
                        <ww:text name="menu.profile.label"/>
                    </a>
                </li>
            </ww:if>

        </ww:if>

        <li id="help">
            <a id="helpLink" href="<ww:text name="help.prefix"/><ww:property value="getSitemeshPageProperty('meta.help.url')"/>" target="_crowdhelp">
                <ww:text name="menu.documentation.label"/>
            </a>
        </li>
        <script type="text/javascript" language="JavaScript">
            // Sets the help link. Called from tabbed pages to change the help link when different tabs are selected.
            function setHelpLink(helpHref)
            {
                document.getElementById('helpLink').href = '<ww:text name="help.prefix"/>' + helpHref;
            }
        </script>
    </ul>
</div>
<!-- END #header -->

<!-- Menu across top of page -->
<ww:if test="admin == true ">
    <div id="menu">
        <ul>
            <ww:iterator value="getWebSectionsForLocation('navigation.top')">
                <ww:iterator value="getWebItemsForSection(key)">
                    <li <ww:if test='key.equals(getSitemeshPageProperty("meta.section"))'>class="on"</ww:if>>
                        <a id="<ww:property value="link.id"/>" href="<ww:property value="getDisplayableLink(link)"/>"><ww:property value="getText(webLabel.key)"/></a>
                    </li>
                </ww:iterator>
            </ww:iterator>
        </ul>
    </div>
    <!-- END #menu -->
</ww:if>
<ww:else>
    <div id="menu-small"></div>
</ww:else>

<div id="wrapper">

<!-- Left-hand side menu for each selected section from top menu above -->

<ww:iterator value="getWebSectionsForLocation('left')">
    <content tag="sub-menu">
        <ul id="sub-menu">

            <ww:iterator value="getWebItemsForSection(key)" status="count">
                <li id="lhstab<ww:property value="#count.index+1"/>" <ww:if test='key.equals(getSitemeshPageProperty("meta.pagename"))'>class="on"</ww:if>>
                    <a id="<ww:property value="link.id"/>" href="<ww:property value="getDisplayableLink(link)"/>"><ww:property value="getText(webLabel.key)"/></a>
                </li>
            </ww:iterator>

        </ul>
    </content>
</ww:iterator>

<div id="content">
    <decorator:body/>
</div>
</div>
<!-- // #wrapper -->

</div>

<div id="footer">
    <p>
        <ww:text name="footer.poweredby"/> <a href="<ww:text name="application.poweredby.url"/>"><ww:text name="application.title"/></a>
        <ww:text name="common.words.version"/>:&nbsp;<ww:property value="@com.atlassian.crowd.util.build.BuildUtils@getVersion()"/>
        <ww:if test="evaluation == true"><ww:text name="license.runningevaluation"/></ww:if>&nbsp;
        <ww:if test="licenseExpired == true"><ww:text name="license.expired"/></ww:if>
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