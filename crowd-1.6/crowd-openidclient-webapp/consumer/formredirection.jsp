<%@ page import="java.util.Map" %>
<%@ page import="java.util.Iterator" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>OpenID HTML FORM Redirection</title>
</head>

<%
    // REQUIRES: String destinationUrl and Map paramaterMap to be in request scope
%>

<body onload="document.forms['openid-form-redirection'].submit();">
    <form name="openid-form-redirection" action="<%= request.getAttribute("destinationUrl") %>" method="post" accept-charset="utf-8">

        <%
            Map params = (Map) request.getAttribute("paramaterMap");
            for (Iterator i = params.keySet().iterator(); i.hasNext(); )
            {
                String key = (String)i.next();
                String value = (String)params.get(key);
        %>
                <input type="hidden" name="<%= key %>" value="<%= value %>"/>
        <%
            }

        %>

        <button type="submit">Continue...</button>

    </form>
</body>
</html>
