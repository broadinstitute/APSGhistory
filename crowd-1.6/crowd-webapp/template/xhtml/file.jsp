<%@ page import="com.atlassian.core.util.FileSize"%>
<%@ page import="com.opensymphony.webwork.config.Configuration" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<%@ include file="/template/xhtml/controlheader.jsp" %>

<input type="file"
       name="<ww:property value="parameters['name']"/>"
        <ww:if test="parameters.nameValue != null">value="<ww:property value="parameters['nameValue']"/>"</ww:if> <%-- NB - this will only work in opera.  IE & Mozilla both ignore it for security reasons --%>
       <ww:if test="parameters.size != null">size="<ww:property value="parameters['size']" />"</ww:if>
       <ww:if test="parameters.cssClass != null">class="<ww:property value="parameters['cssClass']" />"</ww:if>
       <ww:if test="parameters.cssStyle != null">style="<ww:property value="parameters['cssStyle']" />"</ww:if>
       <ww:if test="parameters.title != null">title="<ww:property value="parameters['title']" />"</ww:if>
>
<br /><h5>
<ww:text name="attachfile.filebrowser.warning">
    <ww:param name="'value0'"><%= FileSize.format(new Long(Configuration.getString("webwork.multipart.maxSize"))) %></ww:param>
</ww:text>
    </h5>
<%@ include file="/template/xhtml/controlfooter.jsp" %>