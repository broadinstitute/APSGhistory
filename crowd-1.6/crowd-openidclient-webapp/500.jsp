<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page isErrorPage="true" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<%@ page import="com.opensymphony.util.TextUtils" %>
<%@ page import="org.apache.log4j.Logger" %>
<%@ page import="java.io.PrintWriter" %>
<%@ page import="java.io.StringWriter" %>
<%@ page import="java.util.Enumeration" %>
<html>
<head>
    <title>Oops - an error has occurred</title>
    <style type="text/css" media="all">
        @import "<ww:url value="/console/style/main.css"/>";
        @import "<ww:url value="/console/style/style.css"/>";
        @import "<ww:url value="/console/style/styles.css"/>";
    </style>

    <style type="text/css">
        h1 {
            color: #003366;
            text-align: left;
            margin: 0px 0px 5px 10px;
            padding: 0px;
            border-width: 0px 0px 1px 0px;
            border-style: solid;
            border-color: #003366;
        }

        p {
            padding: 5px 10px 5px 10px;
        }

        pre {
            padding: 5px 10px 5px 10px;
        }
    </style>
    <%
        //SystemInfoHelper systemInfoHelper = new SystemInfoHelperImpl();
        String exCause = null;
        String ex = null;
        if (exception != null)
        {
            Throwable cause = exception;
            if (exception instanceof ServletException)
            {
                Throwable rootCause = ((ServletException) exception).getRootCause();
                if (rootCause != null)
                {
                    cause = rootCause;
                }
            }
            //log exception to the log files, so that it gets captured somewhere.
            Logger.getInstance("500ErrorPage").error("Exception caught in 500 page " + cause.getMessage(), cause);
            exCause = cause.toString();
            StringWriter sw = new StringWriter();
            PrintWriter pw = new PrintWriter(sw);
            cause.printStackTrace(pw);
            ex = sw.toString();
        }
    %>
</head>
<body>
<div class="content">
<ww:i18n name="com.atlassian.crowd.console.action.BaseAction">
<h1>
    <ww:text name="system.error.label"/>
    <ww:property value="getText('system.error.label')"/>
</h1>
<br/>

<p>
    <ww:text name="system.error.message.1.description"/>
    <br/>
    <ww:text name="system.error.message.2.description">
        <ww:param name="value0" value="'<a href=https://support.atlassian.com/>'"/>
        <ww:param name="value1" value="'</a>'"/>
    </ww:text>
    <br/>
    -
    <ww:text name="system.error.message.3.description"/>
    <br/>
    -
    <ww:text name="system.error.message.4.description"/>
    <br/>
    -
    <ww:text name="system.error.message.5.description"/>
    <br/>
</p>

<p><b>
    <ww:text name="system.error.cause.label"/>
    : </b><br/>
    <%= exCause%>
</p>
<% if (ex != null)
{
%>
<p>
    <b>
        <ww:text name="system.error.stack.trace.label"/>
        : </b>
<pre id="stacktrace"><%= ex %></pre>
<% }
else
{ %>
<p><%= request.getAttribute("javax.servlet.error.message") %>
</p>
<% } %>
<p>
    <ww:text name="referer.label"/>
    :
    <b><%= request.getHeader("Referer") != null ? request.getHeader("Referer") : "Unknown" %>
    </b>

</p>

<p>
    <b>
        <ww:text name="system.error.request.information.label"/>
        :</b><br/>
    <%
        try
        {
            String encodedQueryString = request.getQueryString() == null ? " " : TextUtils.htmlEncode(request.getQueryString());
    %>

    -
    <ww:text name="system.error.request.url.label"/>
    : <%= request.getRequestURL() %><br>
    -
    <ww:text name="system.error.scheme.label"/>
    : <%= request.getScheme() %><br>
    -
    <ww:text name="system.error.server.label"/>
    : <%= request.getServerName() %><br>
    -
    <ww:text name="system.error.port.label"/>
    : <%= request.getServerPort() %><br>
    -
    <ww:text name="system.error.uri.label"/>
    : <%= request.getRequestURI() %><br>
    -
    <ww:text name="system.error.context.path.label"/>
    : <%= request.getContextPath() %><br>
    - -
    <ww:text name="system.error.servlet.path.label"/>
    : <%= request.getServletPath() %><br>
    - -
    <ww:text name="system.error.path.info.label"/>
    : <%= request.getPathInfo() %><br>
    - -
    <ww:text name="system.error.query.string.label"/>
    : <%= encodedQueryString %><br><br>

    <b>
        <ww:text name="system.error.request.attributes.label"/>
        :</b><br>
    <%
        Enumeration attributeNames = request.getAttributeNames();
        while (attributeNames.hasMoreElements())
        {
            String name = (String) attributeNames.nextElement();
            Object attribute = request.getAttribute(name);
    %>
    - <%= name %> : <%= TextUtils.htmlEncode(attribute == null ? "null" : attribute.toString()) %><br>
    <%
        }
    %>
    <%
        }
        catch (Throwable t)
        {
            out.println("Error rendering logging information - uh oh.");
            t.printStackTrace(new PrintWriter(out));
        }
    %>
</p>
</div>
</ww:i18n>
</body>
</html>