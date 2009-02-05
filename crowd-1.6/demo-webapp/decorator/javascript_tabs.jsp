<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<script language="javascript">
    var totalTabs = '<%= request.getParameter("totalTabs") %>';

    var tab;
    tab = '<ww:property value="tab" />';

    function init() {
        processTabs(tab);
    }

    function processTabs(tab) {

        <%
            int totalTabs = Integer.parseInt(request.getParameter("totalTabs"));
            for (int i = 1; i <= totalTabs; i++) {
        %>

            if (tab == '<%=i%>') {
                document.getElementById('tab<%=i%>').style.display='block';
                document.getElementById('hreftab<%=i%>').className='on';
            } else {
                document.getElementById('tab<%=i%>').style.display='none';
                document.getElementById('hreftab<%=i%>').className='';
            }

        <%
            }

        %>
    }

</script>