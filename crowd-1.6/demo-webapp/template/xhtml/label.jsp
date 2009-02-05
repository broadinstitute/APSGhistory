<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- label.jsp
  --
  -- Required Parameters:
  --   * label      - The description that will be used to identfy this text label
  --
  -- Optional Parameters:
  --   * labelposition   - determines were the label will be place in relation
  --                       to the control.  Default is to the left of the control.
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>

<label>
    <webwork:if test="parameters['name']"><webwork:property value="parameters['name']"/></webwork:if>
</label>

<%@ include file="controlfooter.jsp" %>