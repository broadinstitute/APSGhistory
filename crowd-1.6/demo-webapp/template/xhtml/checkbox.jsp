<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>

    <input type="checkbox"
        <webwork:if test="parameters['nameValue'] == true">checked="checked"</webwork:if>
        name="<webwork:property value="parameters['name']"/>"
        value="<webwork:property value="parameters['fieldValue']"/>"
        <webwork:if test="parameters['disabled'] == true">disabled="disabled"</webwork:if>
        <webwork:if test="parameters['tabindex'] != null">tabindex="<webwork:property value="parameters['tabindex']"/>"</webwork:if>
        <webwork:if test="parameters['onchange'] != null">onchange="<webwork:property value="parameters['onchange']"/>"</webwork:if>
        <webwork:if test="parameters['id'] != null">id="<webwork:property value="parameters['id']"/>"</webwork:if>
/>

<%@ include file="controlfooter.jsp" %>