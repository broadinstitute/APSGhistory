<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<div class="fieldArea required">

    <%
        if (request.getParameter("warning") != null) {
    %>
    <div class="errorBox">
                <%=request.getParameter("warning") %>
    </div>
    <%
        }
    %>

    <label class="fieldLabelArea" for="Description">
        <%
            if (request.getParameter("label") != null) {
        %>
            <%=request.getParameter("label") %>:
        <%
            }
        %>
    </label>

    <div class="fieldValueArea">
        <%
            if (request.getParameter("value") != null) {
        %>
            <%=request.getParameter("value") %>
        <%
            }
        %>


        <div class="fieldDescription">
            <%
                if (request.getParameter("description") != null) {
            %>
                <%=request.getParameter("description") %>
            <%
                }
            %>
        </div>
    </div>
</div>