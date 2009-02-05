<%@ page import="com.atlassian.crowd.openid.server.provider.CrowdProvider" %>
<%@ page import="com.atlassian.crowd.openid.server.provider.OpenIDAuthRequest" %>
<%@ taglib uri="sitemesh-decorator" prefix="decorator" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<ww:action namespace="/" name="baseaction" >
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>

    <decorator:usePage id="sitemeshPage"/>

    <title>
        <ww:property value="getText('application.title')"/>
        -
        <decorator:title/>
    </title>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="author" content="Atlassian"/>
    <meta name="robots" content="all"/>

    <meta name="MSSmartTagsPreventParsing" content="true"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>

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
                <a href="<ww:url value="/" includeParams="none"/>"><img alt="<ww:text name="application.title"/>" src="<ww:url value="/images/crowdid_server.gif" includeParams="none"/>" height="36" width="119"/></a>
            </div>

            <ul id="userOptions">
                <ww:if test="authenticated == true">
                    <li id="userInfo">
                        <ww:property value="getText('user.label')"/>:&nbsp;
                        <strong>
                            <ww:property value="principalName"/>
                        </strong>
                    </li>

                    <li id="profileLink">
                        <a href="<ww:url namespace="/" action="logoff" includeParams="none"/>">
                            <ww:property value="getText('menu.logout.label')"/>
                        </a>
                    </li>

                    <li id="additionalOption">
                        <a href="<ww:url namespace="/secure/profile" action="changepassword" method="default" includeParams="none"/>">
                            <ww:text name="menu.changepassword.label"/>
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

                <ww:if test="administrator == true">
                    <li <% if ("administration".equals(sitemeshPage.getProperty("meta.section"))) { %> class="on"<% } %>>
                        <a href="<ww:url namespace="/secure/admin" action="viewoptions" includeParams="none"/>"><ww:property value="getText('menu.administrator.label')"/></a>
                    </li>                    
                </ww:if>
                
            </ul>
        </div> <!-- END #menu -->


        <div id="contentLeft">
            
            <ww:if test="authenticated == true">
                <div id="panelMenu">
                    <div class="webMenu">
                         <div class="webMenuSection">

                            <ul>

                                <li>

                                    <% if ("home".equals(sitemeshPage.getProperty("meta.section"))) { %>
                                        <h2>
                                            <ww:text name="userportal.label"/>
                                        </h2>
                                    <%
                                        }
                                        else if ("administration".equals(sitemeshPage.getProperty("meta.section"))) {
                                    %>
                                        <h2>
                                            <ww:text name="administration.label"/>
                                        </h2>
                                    <%
                                        }
                                    %>




                                    <ul class="webMenuItem">

                                    <% if (!"administration".equals(sitemeshPage.getProperty("meta.section"))) { %>

                                        <li <% if ("identifier".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="myidentity" href="<ww:url namespace="/secure/profile" action="viewidentity" includeParams="none"/>"><ww:text name="identity.title"/></a>
                                        </li>
                                        <li <% if ("myprofiles".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="myprofiles" href="<ww:url namespace="/secure/profile" action="editprofiles" includeParams="none"/>"><ww:text name="profiles.title"/></a>
                                        </li>
                                        <li <% if ("approvedsites".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="mysites" href="<ww:url namespace="/secure/interaction" action="editallowalways" method="default" includeParams="none"/>"><ww:text name="allow.edit.title"/></a>
                                        </li>
                                        <li <% if ("authhistory".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="activity" href="<ww:url namespace="/secure/interaction" action="viewauthrecord" includeParams="none"/>"><ww:text name="auth.record.title"/></a>
                                        </li>

                                    <%
                                        }
                                    %>

                                    <ww:if test="administrator == true">
                                    <% if ("administration".equals(sitemeshPage.getProperty("meta.section"))) { %>
                                        <li <% if ("generalconfiguration".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="generalconfiguration" href="<ww:url namespace="/secure/admin" action="viewoptions" includeParams="none"/>"><ww:text name="generalconfiguration.label"/></a>
                                        </li>
                                        <li <% if ("trustrelationships".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="loginrestrictions" href="<ww:url namespace="/secure/admin" action="viewtrustrelationships" includeParams="none"/>"><ww:text name="trusts.label"/></a>
                                        </li>
                                        <li <% if ("crowdserversettings".equals(sitemeshPage.getProperty("meta.subsection"))) { %> class="on"<% } %>>
                                            <a id="crowdserversettings" href="<ww:url namespace="/secure/admin" action="crowdserver" includeParams="none"/>"><ww:text name="crowdserver.label"/></a>
                                        </li>
                                    <%
                                        }
                                    %>
                                    </ww:if>

                                </ul>

                                </li>

                            </ul>
                         </div>
                    </div>

                    <%
                        // check if we are on the authentication screen, we do not need to display the panel
                        // option because we are already on the screen
                        boolean inAuthorizationScreen = "true".equals(sitemeshPage.getProperty("meta.openidauthmode"));

                        // check if we also have an authorization object
                        OpenIDAuthRequest authenticationRequest = (OpenIDAuthRequest) session.getAttribute(CrowdProvider.OPENID_AUTHENTICATION_REQUEST);

                        // if we are not on the authorization screen AND the openid login request is present, show the menu option.
                        if (!inAuthorizationScreen && authenticationRequest != null)
                        {
                    %>

                   <div class="webMenu">
                         <div class="webMenuSection">

                            <ul>

                                <li>

                                    <h2><ww:property value="getText('allow.auth.title')"/></h2>




                                    <ul class="webMenuItem">

                                    <a id="resumeauthentication" href="<ww:url namespace="/secure/interaction" action="allowauthentication" method="default" includeParams="none"/>">
                                            <ww:property value="getText('resumeverification.label')"/>
                                    </a>

                                </ul>

                                </li>

                            </ul>
                         </div>
                    </div>

                    <%
                        }
                    %>

                </div>



                <div id="panelContent">
                    <decorator:body/>
                </div>
                
            </ww:if>
            <ww:else>

                <div id="content">
                    <decorator:body/>
                </div>

            </ww:else>

        </div>



</div> <!-- END #nonFooter -->

<div id="footer">
    <p>
        <ww:text name="footer.poweredby"/>&nbsp;<a href="<ww:text name="application.poweredby.url"/>"><ww:text name="application.title"/></a>
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

</body>
</html>
</ww:action>