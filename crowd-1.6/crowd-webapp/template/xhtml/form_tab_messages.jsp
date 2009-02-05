<%@ taglib uri="/webwork" prefix="ww" %>

<ww:if test="parameters['tabID'].equals(tab)">
    <ww:component template="form_messages.jsp"/>
</ww:if>