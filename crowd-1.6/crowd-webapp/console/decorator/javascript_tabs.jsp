<%@ page import="com.atlassian.crowd.integration.directory.connector.LDAPPropertiesMapper" %>
<%@ page import="com.atlassian.crowd.util.connector.LDAPPropertiesHelper" %>
<%@ page import="com.atlassian.spring.container.ContainerManager" %>
<%@ page import="java.util.Collection" %>
<%@ page import="java.util.Iterator" %>
<%@ page import="java.util.Properties" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<script type="text/javascript" language="javascript">
    var totalTabs = '<%= request.getParameter("totalTabs") %>';

    var tab;
    tab = '<ww:property value="tab" />';

    function init() {
        processTabs(tab);
    }

    function flickTab(tab, on)
    {
        var tabLinkElt = document.getElementById('hreftab' + tab);
        var tabContentElt = document.getElementById('tab' + tab);

        if (tabLinkElt)
        {
            if (on)
            {
                tabLinkElt.className='on';
            }
            else
            {
                tabLinkElt.className='off';
            }
        }

        if (tabContentElt)
        {
            if (on)
            {
                tabContentElt.style.display='block';
            }
            else
            {
                tabContentElt.style.display='none';
            }
        }
    }

    function processTabs(tab) {
        <%
            int totalTabs = Integer.parseInt(request.getParameter("totalTabs"));
            for (int i = 1; i <= totalTabs; i++) {
        %>
                if (tab == '<%=i%>')
                {
                    flickTab('<%=i%>', true);
                }
                else
                {
                    flickTab('<%=i%>', false);
                }
        <%
            }
        %>
    }

</script>